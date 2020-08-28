#!/bin/bash

# Meant to be used instead of docker-compose.yml, and
# in combination with Valet, see GOING_NATIVE.md for more info.
docker run \
  -it \
  -p 4306:3306 \
  -e "MYSQL_ROOT_PASSWORD=somegloriouspassword" \
  -e "MYSQL_DATABASE=craft_cms" \
  -v $(pwd)/docker-src/db-config:/etc/mysql/conf.d:cached \
  -v $(pwd)/docker-src/db-dump:/docker-entrypoint-initdb.d:cached \
  --cap-add SYS_NICE \
  mysql:8