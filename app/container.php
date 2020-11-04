<?php
$app = new \Slim\App([
'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'slimproject',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
]);

// Get container
$container = $app->getContainer();


 
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};


  $container['auth'] = function($container) 
 {
    return new \App\Controllers\PageController($container);
 };


// Register component on container
$container['view'] = function ($container) {
	$dir=dirname(__DIR__);
    $view = new \Slim\Views\Twig($dir.'/app/views', [
        'cache' => false //$dir .'/tmp/cache'
    ]);
 
 //$container PageController =function($container) return new 




    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));




    $view->getEnvironment()->addGlobal('auth',[
    'check'=>$container->auth->check(),
    'user'=>$container->auth->user(),
    ]);

    return $view;
};

 