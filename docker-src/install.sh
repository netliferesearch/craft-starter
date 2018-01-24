#!/bin/bash

# This is a startup script that gets added by the Dockerfile
# so that composer dependencies will be installed on startup.
composer install -d /var/www/html

apache2-foreground
