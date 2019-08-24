<?php

use App\Controllers\HomeController;
use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;

$container = new Container;
AppFactory::setContainer($container);

$container->set('view', function () {
    return new Twig('../views', [ 'cache' => false ]);
});

$container->set(HomeController::class, function () use ($container) {
    return new HomeController(
        $container->get('view')
    );
});
