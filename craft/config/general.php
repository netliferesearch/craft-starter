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
        'siteUrl' => 'http://localhost:5000/',
        'environmentVariables' => array(
            'siteUrl' => 'http://localhost:5000',
            'basePath' => realpath(getcwd() . '/public/')
        )
    ),
    'herokuapp.com' => array(
        'omitScriptNameInUrls' => true,
        'siteUrl' => 'http://myapp.herokuapp.com/',
        'postLoginRedirect' => '/',
        'environmentVariables' => array(
            'siteUrl' => 'http://myapp.herokuapp.com',
            'basePath' => realpath(getcwd() . '/public/')
        )
    )
);
