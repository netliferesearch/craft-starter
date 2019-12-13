<?php
/**
 * Database Configuration
 *
 * All of your system's database connection settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/DbConfig.php.
 *
 * @see craft\config\DbConfig
 */

$db_url = parse_url(getenv('JAWSDB_URL') ?: getenv('DATABASE_URL'));

return [
    'driver' => "mysql", // set mysql or psql
    'server' => $db_url['host'],
    'user' => $db_url['user'],
    'password' => $db_url['pass'],
    'database' => substr($db_url['path'],1),
    'tablePrefix' => 'craft'
];
