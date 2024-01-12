<?php

/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see craft\config\GeneralConfig
 */

use craft\config\GeneralConfig;
use craft\helpers\App;

$isDev = App::env('CRAFT_ENVIRONMENT') === 'dev';
$isProd = App::env('CRAFT_ENVIRONMENT') === 'production';

return GeneralConfig::create()
    ->aliases([
        '@webroot' => App::env('WEB_ROOT_PATH'),
        '@web' => App::env('SITE_URL'),
    ])
    ->allowAdminChanges($isDev)
    ->allowUpdates($isDev)
    ->devMode($isDev)
    ->securityKey(App::env('SECURITY_KEY'))
    ->disallowRobots(!$isProd)
    ->omitScriptNameInUrls(true)
    ->defaultWeekStartDay(1)
    ->cpTrigger(App::env('CP_TRIGGER') ?: 'admin')
    ->limitAutoSlugsToAscii(true)
    ->accessibilityDefaults([
        'alwaysShowFocusRings' => true,
        'useShapes' => true,
    ]);
