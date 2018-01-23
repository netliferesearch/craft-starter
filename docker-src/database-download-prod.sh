#!/usr/bin/env bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

echo "Note: Be sure to have to have ./open-tunnel-arcustech.sh script running"
echo "or else this script should fail."

# this requires us to have a ssh tunnel open
mysqldump --compress --verbose \
  -u av04900 -p$ARCUSTECH_DB_PASSWORD \
  --host 127.0.0.1 \
  av04900debergenske > docker-src/db-dump/dump.sql
