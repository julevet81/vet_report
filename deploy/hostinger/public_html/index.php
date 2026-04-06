<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Hostinger public_html front controller for Laravel app outside public_html.
// Keep this file inside public_html and place the Laravel project in a sibling folder
// such as /home/<user>/vet_reports.

define('LARAVEL_START', microtime(true));

$possibleAppRoots = [
    realpath(__DIR__.'/../vet_reports'),
    realpath(__DIR__.'/../laravel_app'),
    realpath(__DIR__.'/../app'),
];

$appRoot = null;

foreach ($possibleAppRoots as $root) {
    if ($root && file_exists($root.'/bootstrap/app.php')) {
        $appRoot = $root;
        break;
    }
}

if ($appRoot === null) {
    http_response_code(500);
    echo 'Laravel app root not found. Update deploy/hostinger/public_html/index.php paths.';
    exit;
}

if (file_exists($maintenance = $appRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appRoot.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $appRoot.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
