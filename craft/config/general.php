<?php
define('BASEPATH', realpath(CRAFT_BASE_PATH . '/../') . '/');

/* Lets load that .env file if it exists */
require BASEPATH . '/vendor/autoload.php';
if (file_exists(BASEPATH . '.env')) {
  $dotenv = new Dotenv\Dotenv(BASEPATH);
  $dotenv->required(['CLEARDB_DATABASE_URL']);
  $dotenv->load();
}

return array(
    '*' => array(
        'generateTransformsBeforePageLoad' => true,
        'defaultCpLanguage' => 'en',
        'allowAutoUpdates' => false,
        'cache' => true,
        'usePathInfo' => true /* This fixes the Heroku no resources found issue*/
    ),
    'localhost' => array(
        'devMode' => true,
        'cache' => false,
        'siteUrl' => 'http://localhost:5000/',
        'allowAutoUpdates' => true,
        'environmentVariables' => array(
            'siteUrl' => 'http://localhost:5000',
            'basePath' => realpath(getcwd() . '/public/')
        )
    ),
    'herokuapp.com' => array(
        'omitScriptNameInUrls' => true,
        'siteUrl' => 'http://{{name}}.herokuapp.com/',
        'postLoginRedirect' => '/',
        'allowAutoUpdates' => false,
        'environmentVariables' => array(
            'siteUrl' => 'http://{{name}}.herokuapp.com',
            'basePath' => realpath(getcwd() . '/public/')
        )
    )
);
