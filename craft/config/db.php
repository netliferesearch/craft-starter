<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

$production_url = parse_url(getenv('DATABASE_URL'));
$staging_url = parse_url(getenv('JAWSDB_URL'));
$local_url = parse_url(getenv('LOCAL_DATABASE_URL'));

return array(
  '*' => array(
    'tablePrefix' => 'craft',
    'server' => $staging_url['host'],
    'user' => $staging_url['user'],
    'password' => $staging_url['pass'],
    'database' => substr($staging_url['path'],1)
  ),/*
  '{{name}}.com' => array(
    'tablePrefix' => 'craft',
    'server' => $production_url['host'],
    'user' => $production_url['user'],
    'password' => $production_url['pass'],
    'database' => substr($production_url['path'],1)
  ),*/
  'herokuapp.com' => array(
      'tablePrefix' => 'craft',
      'server' => $staging_url['host'],
      'user' => $staging_url['user'],
      'password' => $staging_url['pass'],
      'database' => substr($staging_url['path'],1)
  ),
  'localhost' => array(
      'tablePrefix' => 'craft',
      'server' => $local_url['host'],
      'user' => $local_url['user'],
      'password' => $local_url['pass'],
      'database' => substr($local_url['path'],1),
      'port' => $local_url['port']
  )
);
