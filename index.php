#!/usr/bin/env php
<?php
if (php_sapi_name() !== 'cli') {
    echo "Execute from command line!!!";
    exit;
}
define('GAME_START', microtime(true));

require __DIR__.'/vendor/autoload.php';
$config = require_once __DIR__.'/config/app.php';

(new App\Application($config))->run();
exit;