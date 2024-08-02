<?php

declare(strict_types=1);

require_once('Router.php');
require_once('Controller.php');

$router = new Router();
$router->add('GET', '/', [SiteController::class, 'home']);
$router->add('GET', '/about', [SiteController::class, 'about']);

// Fixing the parse_url and PHP_URL_PATH usage
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($path);
