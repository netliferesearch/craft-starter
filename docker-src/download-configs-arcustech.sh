#!/bin/bash

echo "Downloading remote config files"

rsync -avz av04900@185.193.216.36:/storage/av04900/www/public_html/craft/config/db.php craft/config/db.php
rsync -avz av04900@185.193.216.36:/storage/av04900/www/public_html/craft/config/general.php craft/config/general.php
