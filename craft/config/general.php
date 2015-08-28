<?php
define('BASEPATH', realpath(CRAFT_BASE_PATH . '/../') . '/');

return array(
    '*' => array(
        'generateTransformsBeforePageLoad' => true,
        'cache' => true,
    ),
    'localhost' => array(
        'devMode' => true,
        'cache' => false,
        'siteUrl' => array(
            'en' => 'http://localhost:9091',
            'no' => 'http://localhost:9091/no'
        ),
        'environmentVariables' => array(
            'siteUrl' => 'http://localhost:9091',
            'basePath' => realpath(getcwd() . '/public/')
        )
    ),
    'prototypes.no' => array(
        'omitScriptNameInUrls' => true,
        'siteUrl' => array(
            'en' => 'http://{{name}}.prototypes.no',
            'no' => 'http://{{name}}.prototypes.no/no',
        ),
        'environmentVariables' => array(
            'siteUrl' => 'http://{{name}}.prototypes.no',
            'basePath' => realpath(getcwd() . '/public/')
        )
    )
);
