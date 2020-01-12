<?php

require_once __DIR__ . '/../vendor/autoload.php';

$container = new \DI\Container();

\Slim\Factory\AppFactory::setContainer($container);
$app = \Slim\Factory\AppFactory::create();

$container->set('settings', function () {
    return [
        'displayErrorDetails' => true,

        'app' => [
            'name' => 'App'
        ],

        'views' => [
            'cache' => false
        ]
    ];
});

$twig = new Slim\Views\Twig(__DIR__ . '/../views', [
    'cache' => $container->get('settings')['views']['cache']
]);

$container->set('view', $twig);

$app->add(\Slim\Views\TwigMiddleware::createFromContainer($app));

$errorMiddleware = new \Slim\Middleware\ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    false,
    false
);

$errorMiddleware->setErrorHandler(\Slim\Exception\HttpNotFoundException::class, function ($request, $exception) use ($container) {
    $response = new \Slim\Psr7\Response();

    return $container->get('view')->render($response->withStatus(404), 'errors/404.twig');
});

$app->add($errorMiddleware);

require '../routes/web.php';
