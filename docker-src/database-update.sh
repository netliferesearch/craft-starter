#!/usr/bin/env bash

docker-compose rm -f -s -v database && \
  docker-compose up -d database
