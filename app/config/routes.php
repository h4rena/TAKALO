<?php

use app\controllers\ApiProductController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
    /*
	 $router->get('/', function() {
        require __DIR__ . '/../../app/views/home.php';
    });
    $router->get('/home',function() {
        require __DIR__ . '/../../app/views/home.php';
        
    });
	$router->get('/produit',function() {
        require __DIR__ . '/../../app/views/produit.php';
    });
    $router->post('/produit', function() {
        require __DIR__ . '/../../app/views/produit.php';
    });


	$router->group('/api', function() use ($router) {
		$router->get('/products', [ ApiProductController::class, 'getproducts' ]);
		$router->get('/products/@id:[0-9]', [ ApiProductController::class, 'getproduct' ]);
		$router->post('/products/@id:[0-9]', [ ApiProductController::class, 'updateProduct' ]);
	});
	*/
}, [ SecurityHeadersMiddleware::class ]);