'use strict'

require('dotenv').config()
require('shelljs/global')

const url = require('url')
const mysqlDump = require('mysqldump')

const dbCreds = url.parse(process.env.CLEARDB_DATABASE_URL)
const localDbUser = process.env.LOCAL_DB_USER
const localDbPass = process.env.LOCAL_DB_PASS
const localDbName = process.env.LOCAL_DB_NAME
console.log('Downloading database')

/*
if data.sql
  rm data_backup.sql
  mv data.sql data_backup.sql
*/

mysqlDump({
  host: dbCreds.host,
  user: dbCreds.auth.split(':')[0],
  password: dbCreds.auth.split(':')[1],
  database: dbCreds.pathname.replace('/', ''),
  dest: './data.sql'
}, (err) => {
  console.log(err)
  console.log('Starting Mysql')
  exec(`sed -im '1s/^/set foreign_key_checks=0;/' data.sql`)
  exec('mysql.server start')
  if (exec(`mysql -u ${localDbUser} -p${localDbPass} -e "use ${localDbName}"`).code !== 0) {
    console.log('Creating database')
    exec(`mysql -u ${localDbUser} -p${localDbPass} -e "create database if not exists ${localDbName}"`)
  } else {
    exec(`mysql -u ${localDbUser} -p${localDbPass} -e "drop database ${localDbName}"`)
    exec(`mysql -u ${localDbUser} -p${localDbPass} -e "create database if not exists ${localDbName}; "`)
  }
  console.log('Importing database');
  exec(`mysql -u ${localDbUser} -p${localDbPass} ${localDbName} < data.sql`)
  console.log('Database imported!')
  process.exit(1)
})
