#!/bin/bash

echo "Starting install script"

# Installs composer dependencies if they were to be missing.
composer install -d /var/www/html

apache2-foreground
