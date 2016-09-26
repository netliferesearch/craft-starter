'use strict'

require('dotenv').config()
require('shelljs/global')

const inq = require('inquirer')
const url = require('url')
const mysqlDump = require('mysqldump')
const dbCreds = url.parse(process.env.CLEARDB_DATABASE_URL)
const localDbCreds = url.parse(process.env.LOCAL_DATABASE_URL)
const localDbName = localDbCreds.pathname.replace('/', '')
const localDbHost = localDbCreds.host
let localDbUser = localDbCreds.auth.split(':')[0]
let localDbPass = localDbCreds.auth.split(':')[1] || null

console.log(`Localhost: ${localDbHost}\n; Local DB name: ${localDbName}\n`)
const questions = [
  {
    type: 'confirm',
    name: 'sync',
    message: 'You will loose whatever you\'ve done in the database locally. Are you sure you want to do this?',
    default: true,
  },
  {
    type: 'input',
    name: 'username',
    message: 'Your MySQL username, usually “root”',
    default: 'root'
  },
  {
    type: 'password',
    name: 'password',
    message: 'Your MySQL password, if you have one',
    default: localDbPass
  }
]
inq.prompt(questions, answers => {
  if(answers.sync) {
    localDbUser = answers.username
    localDbPass = answers.length > 0 ? `&password='${answers.password}'` : null
    console.log('Downloading database')

    mysqlDump({
      host: dbCreds.host,
      user: dbCreds.auth.split(':')[0],
      password: dbCreds.auth.split(':')[1],
      database: dbCreds.pathname.replace('/', ''),
      dest: './data.sql'
    }, (err) => {
      console.log('Starting Mysql')
      if (localDbPass) {
        exec(`echo "[client]&host=${localDbHost}&user=${localDbUser}${localDbPass}"> my.cnf`)
      } else {
        exec(`echo "[client]&host=${localDbHost}&user=${localDbUser}"> my.cnf`)
      }
      exec(`sed -im '1s/^/set foreign_key_checks=0;/' data.sql`)
      exec('mysql.server start')
      if (exec(`mysql --login-path=local -e "use ${localDbName}"`).code !== 0) {
        console.log('Creating database')
        exec(`mysql --login-path=local -e "create database if not exists ${localDbName}"`)
      } else {
        exec(`mysql --login-path=local -e "drop database ${localDbName}"`)
        exec(`mysql --login-path=local -e "create database if not exists ${localDbName}; "`)
      }
      console.log('Importing database');
      exec(`mysql --login-path=local ${localDbName} < data.sql`)
      console.log('Deleting import files');
      exec(`rm data.sq*`)
      console.log('Database imported!')
      process.exit(0)
    })
  } else {
    console.log('No harm done!')
    process.exit(0)
  }
})
/*
if data.sql
  rm data_backup.sql
  mv data.sql data_backup.sql
*/
