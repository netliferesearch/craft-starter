<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see craft\config\GeneralConfig
 */

return [
    // Global settings
    '*' => [
        // Default Week Start Day (0 = Sunday, 1 = Monday...)
        'defaultWeekStartDay' => 0,

        // Enable CSRF Protection (recommended)
        'enableCsrfProtection' => true,

        // Whether generated URLs should omit "index.php"
        'omitScriptNameInUrls' => true,

        // Control Panel trigger word
        'cpTrigger' => 'admin',

        // The secure key Craft will use for hashing and encrypting data
        'securityKey' => getenv('CRAFT_SECURITY_KEY'),

        // avoid æøå in slugs.
        'limitAutoSlugsToAscii' => true,

        // be sure to update php upload limit also
        'maxUploadFileSize' => '20M'
    ],

    // Dev environment settings
    'dev' => [
        // siteUrl is deprecated, use .env-vars instead
        // Dev Mode (see https://craftcms.com/support/dev-mode)
        'devMode' => true,
    ],
    
    // Production environment settings
    'production' => [
        // siteUrl is deprecated, use .env-vars instead PRIMARY_SITE_URL
    ],
];
