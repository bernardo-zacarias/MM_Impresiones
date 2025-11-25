<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../proyecto/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../proyecto/vendor/autoload.php'; // <--- CORRECCIÓN DE RUTA

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../proyecto/bootstrap/app.php'; // <--- CORRECCIÓN DE RUTA

$app->handleRequest(Request::capture());