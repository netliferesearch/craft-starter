#!/usr/bin/env bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

mysqldump --compress --verbose \
 -u $STAGE_DB_USER -p$STAGE_DB_PASSWORD \
 --host $STAGE_DB_HOST \
 $STAGE_DB_NAME > docker-src/db-dump/dump.sql
