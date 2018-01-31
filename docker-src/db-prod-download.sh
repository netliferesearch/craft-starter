#!/usr/bin/env bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

echo "Note: Be sure to have to have 'npm run db:tunnel' script running"
echo "or else this script will fail."

# this requires us to have a ssh tunnel open
mysqldump --compress --verbose \
  -u $ARCUSTECH_DB_USER -p$ARCUSTECH_DB_PASSWORD \
  --host 127.0.0.1 \
  $ARCUSTECH_DB_NAME > docker-src/db-dump/dump.sql
