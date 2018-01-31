#!/bin/bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

ssh $SSH_HOST tail -f /storage/av04900/logs/*
