<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

$url = parse_url(getenv('CLEARDB_DATABASE_URL'));
if (!$url["path"]) {
  echo "<p><b>Database configuration is either missing or wrong in .env</b>.</p><p>Here is what we get from the .env file</p>";
  echo "<pre>";
  var_dump($url);
  die();
}

return array(
  '*' => array(
    'tablePrefix' => 'craft',
    'server' => $url['host'],
    'user' => $url['user'],
    'password' => $url['pass'],
    'database' => substr($url['path'],1)
  )
);
