#!/usr/bin/env bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

# Helper script for downloading a copy of the remote staging database
# To activate this script replace USER, HOST_URL and DATABASE_NAME with actual
# values.
mysqldump --compress --verbose \
 -u USER -p$STAGE_DB_PASSWORD \
 --host HOST_URL \
 DATABASE_NAME > docker-src/db-dump/dump.sql
