<?php

/**
 * Database Configuration
 *
 * All of your system's database configuration settings go in here.
 * You can see a list of the default settings in craft/app/etc/config/defaults/db.php
 */

return array(
    '*' => array(
        'database' => '{{name}}',
        'tablePrefix' => 'craft',
    ),
    'localhost' => array(
        'server' => 'server.prototypes.no',
        'user' => '{{dbUser}}',
        'password' => '{{dbPass}}',
        'database' => '{{dbName}}'
    ),
    'prototypes.no' => array(
        'server' => 'localhost',
        'user' => '{{dbUser}}',
        'password' => '{{dbPass}}',
        'database' => '{{dbName}}'
    )
);
