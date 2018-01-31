#!/usr/bin/env bash

# Use when you want to replace (refresh) the database while docker-compose is
# already running.
docker-compose rm -f -s -v database && \
  docker-compose up -d database
