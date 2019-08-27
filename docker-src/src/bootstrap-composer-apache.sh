#!/bin/bash

# Allow php process to touch any files within the
# container. Beware, never use this in production!
usermod --non-unique --uid 1000 www-data

# This is a startup script that gets added by the Dockerfile
# so that composer dependencies will be installed on startup.
composer install

apache2-foreground
