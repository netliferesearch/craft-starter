<?php
define('BASEPATH', realpath(CRAFT_BASE_PATH . '/../') . '/');

/* Lets load that .env file if it exists. This requires that you've run composer */
require BASEPATH . '/vendor/autoload.php';
if (file_exists(BASEPATH . '.env')) {
  $dotenv = new Dotenv\Dotenv(BASEPATH);
  $dotenv->load();
}

/*
 * Read more about config settings
 * at https://craftcms.com/docs/config-settings
 * */

return array(
    '*' => array(
        'generateTransformsBeforePageLoad' => true,
        'defaultCpLanguage' => 'en', /* Default language for Control Panel */
        'defaultWeekStartDay' => '1', /* Sets start of the week on Mondays */
        'allowAutoUpdates' => false, /* Prevents updating Craft on Heroku */
        'cache' => true,
        'cacheMethod' => 'redis', /* Default caching to Redis, but not on localhost */
        'enableCsrfProtection' => false, /* This should be true, but read  https://craftcms.com/support/csrf-protection first */
        'useCompressedJs' => false, /* Craft can compress JS, haven't been tested */
        'maxUploadFileSize' => 10000000, /* Set to 100MB, see also public/.user.ini */
        'usePathInfo' => true, /* This fixes the Heroku no resources found issue*/
	'limitAutoSlugsToAscii' => true /* Prevent generating urls with æ,ø,å. */
    ),
    'localhost' => array(
        'devMode' => true, /* better for debugging, never in production */
        'cache' => false,
        'cacheMethod' => 'file', /* Default caching to Redis, but not on localhost */
        'siteUrl' => 'http://localhost:5000/',
        'allowAutoUpdates' => true,
        'environmentVariables' => array(
            'siteUrl' => 'http://localhost:5000',
            'basePath' => realpath(getcwd() . '/public/')
        )
    ),
    'herokuapp.com' => array(
        'omitScriptNameInUrls' => true,
        'siteUrl' => 'https://{{name}}.herokuapp.com/', /* remember to change {{name}} to your heroku app */
        'postLoginRedirect' => '/',
        'environmentVariables' => array(
            'siteUrl' => 'https://{{name}}.herokuapp.com', /* remember to change {{name}} to your heroku app */
            'basePath' => realpath(getcwd() . '/public/')
        )
    )/*,
    'production.url' => array(
        'omitScriptNameInUrls' => true,
        'siteUrl' => 'https://www.production.url/',
        'postLoginRedirect' => '/',
        'allowAutoUpdates' => false,
        'environmentVariables' => array(
            'siteUrl' => 'https://www.production.url/',
            'basePath' => realpath(getcwd() . '/public/')
        )
    */
);
