#!/usr/bin/env bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

# Helper script for pushing a local .sql file to staging server.
#
# When setting this up you hardcode USER, HOST_URL and DATABASE_NAME. But the
# staging password will be in the .env file since we do not want to commit it
# to our repositories.
#
# Why do we hardcode you might ask, because accidentally pushing to prod is
# not something that you want to do.
mysql --compress --verbose \
 -u USER -p$STAGE_DB_PASSWORD \
 --host HOST_URL \
 DATABASE_NAME < docker-src/db-dump/dump.sql
