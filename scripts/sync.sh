#!bin/bash
echo "This script require JAWS DB"
echo "Pulling down database"
heroku config:get JAWSDB_URL --remote heroku |cat $1|sed -E 's%mysql:\/\/(.+):(.+)@(.+)(:\d+| )\/(.+)($|.reconnect=true)%mysqldump --verbose --host=\3 --user=\1 --password=\2 \5%'|sh > dump.sql
DB=$(grep LOCALDB .env|sed -E 's%LOCAL_DATABASE_URL=mysql:\/\/(.*)(.*):(.*)@(.*)(:\d+|.*)(.*)\/%mysql --verbose --user=\1 --password=\3 --host=\4  %')
echo "INSERTING DATABASE"
$DB < dump.sql
