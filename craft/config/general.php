<?php
define('BASEPATH', realpath(CRAFT_BASE_PATH . '/../') . '/');

/* Lets load that .env file if it exists. This requires that you've run composer */
require BASEPATH . '/vendor/autoload.php';
if (file_exists(BASEPATH . '.env')) {
  $dotenv = new Dotenv\Dotenv(BASEPATH);
  $dotenv->load();
}

// Use redis to cache php session data
// source: https://york.io/2016/07/22/redis-persist-sessions-php-heroku.html
$prodRedisUrl = '';
if(!empty($_ENV['REDIS_URL'])) {
  $redisUrlParts = parse_url($_ENV['REDIS_URL']);
  $prodRedisUrl = "tcp://$redisUrlParts[host]:$redisUrlParts[port]?auth=$redisUrlParts[pass]";
}

/*
 * Read more about config settings
 * at https://craftcms.com/docs/config-settings
 * */

return array(
    '*' => array(
        'defaultSearchTermOptions' => array( /* Fuzzy search, removes need to end search term with an asterix */
            'subLeft' => false,
            'subRight' => true,
        ),
        'generateTransformsBeforePageLoad' => true,
        'defaultCpLanguage' => 'en', /* Default language for Control Panel */
        'defaultWeekStartDay' => '1', /* Sets start of the week on Mondays */
        'allowAutoUpdates' => false, /* Prevents updating Craft on Heroku */
        'enableTemplateCaching' => false,
        'enableCsrfProtection' => false, /* This should be true, but read  https://craftcms.com/support/csrf-protection first */
        'useCompressedJs' => false, /* Craft can compress JS, haven't been tested */
        'maxUploadFileSize' => 10000000, /* Set to 100MB, see also public/.user.ini */
        'usePathInfo' => true, /* This fixes the Heroku no resources found issue*/
	      'limitAutoSlugsToAscii' => true /* Prevent generating urls with æ,ø,å. */
    ),
    'localhost' => array(
        'devMode' => true, /* better for debugging, never in production */
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
        'devMode' => false, /* set this to true if you want more verbose error messages on herkou */
        'siteUrl' => 'https://{{name}}.herokuapp.com/', /* remember to change {{name}} to your heroku app */
        'postLoginRedirect' => '/',
        'environmentVariables' => array(
            'siteUrl' => 'https://{{name}}.herokuapp.com', /* remember to change {{name}} to your heroku app */
            'basePath' => realpath(getcwd() . '/public/')
        ),/*
        Enable these config settings to properly store php sessions in Redis
        for this to work you'll need to add the Heroku Redis addon to your
        heroku app.
        'cacheMethod' => 'redis',
        'appId' => 'anUniqueAppId', // Must be set since Craft uses this to fingerprint its data caching and sessions
        'overridePhpSessionLocation' => $prodRedisUrl, // See above for how the redis url is fetched and prepared.
        'validationKey' => $_ENV['CRAFT_VALIDATION_KEY'], */ // Should be set to a long string in your environment
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
