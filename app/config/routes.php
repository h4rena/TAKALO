<?php

use app\controllers\ApiProductController;
use app\controllers\LoginController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$ds = DIRECTORY_SEPARATOR;
$publicPath = realpath(__DIR__ . $ds . '..' . $ds . '..' . $ds . 'public');
$publicUrl = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
$publicUrl = $publicUrl === '' ? '/' : $publicUrl . '/';

$app->set('app.public_path', $publicPath);
$app->set('app.public_url', $publicUrl);

if ($app->get('flight.base_url') === '/' && $publicUrl !== '/') {
    $app->set('flight.base_url', $publicUrl);
}

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
    $router->get('/', [ LoginController::class, 'show' ]);
    $router->get('/login', [ LoginController::class, 'show' ]);
    $router->post('/login', [ LoginController::class, 'authenticate' ]);
    $router->post('/register', [ LoginController::class, 'register' ]);
    $router->get('/logout', [ LoginController::class, 'logout' ]);
    $router->get('/home', function() use ($app) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (empty($_SESSION['user'])) {
            $app->redirect('/login');
            return;
        }
        $app->render('home');
    });
}, [ SecurityHeadersMiddleware::class ]);