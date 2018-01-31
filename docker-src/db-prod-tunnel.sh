#!/usr/bin/env bash

# initialize environment variables
# source: http://stackoverflow.com/a/30969768
set -o allexport
source .env
set +o allexport

echo "Please note: When tunnel is open you won't see a success message."

ssh -L 127.0.0.1:3308:127.0.0.1:3306 $SSH_HOST -N
