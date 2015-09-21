<?php
define('BASEPATH', realpath(CRAFT_BASE_PATH . '/../') . '/');

return array(
    '*' => array(
        'generateTransformsBeforePageLoad' => true,
        'defaultCpLanguage' => 'en',
        'cache' => true,
    ),
    'localhost' => array(
        'devMode' => true,
        'cache' => false,
        'siteUrl' => array(
            'no' => 'http://localhost:8080',
            'en' => 'http://localhost:8080/en'
        ),
        'environmentVariables' => array(
            'siteUrl' => 'http://localhost:8080',
            'basePath' => realpath(getcwd() . '/public/')
        )
    ),
    'prototypes.no' => array(
        'omitScriptNameInUrls' => true,
        'siteUrl' => array(
            'no' => 'http://{{name}}.prototypes.no',
            'en' => 'http://{{name}}.prototypes.no/en',
        ),
        'environmentVariables' => array(
            'siteUrl' => 'http://{{name}}.prototypes.no',
            'basePath' => realpath(getcwd() . '/public/')
        )
    )
);
