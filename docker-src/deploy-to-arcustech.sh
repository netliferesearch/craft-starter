#!/usr/bin/env bash

# Helper script for manually deploying files to arcustech.
# Replace USERNAME with deploy target.
rsync --exclude '.env' \
  --exclude 'node_modules' \
  --exclude '.git' \
  --exclude 'craft/storage' \
  -r -avz . USERNAME@IP:/storage/USERNAME/www/public_html
