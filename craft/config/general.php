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
        'siteUrl' => 'http://localhost:8080/',
        'environmentVariables' => array(
            'siteUrl' => 'http://localhost:8080',
            'basePath' => realpath(getcwd() . '/public/')
        )
    ),
    'herokuapp.com' => array(
        'omitScriptNameInUrls' => true,
        'siteUrl' => 'http://{{name}}.herokuapp.com/',
        'environmentVariables' => array(
            'siteUrl' => 'http://{{name}}.herokuapp.com',
            'basePath' => realpath(getcwd() . '/public/')
        )
    )
);
