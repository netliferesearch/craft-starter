#!/usr/bin/env bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

# hardcode target because we do not mistakenly want to push to prod
mysql --compress --verbose \
 -u z5e7iwqx8znb26hp -p$STAGE_PASSWORD \
 --host u3y93bv513l7zv6o.chr7pe7iynqr.eu-west-1.rds.amazonaws.com \
 khe4zx5encg0ao15 < docker-src/db-dump/dump.sql
