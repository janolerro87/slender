<?php

use Slim\Exception\HttpNotFoundException;
use Slim\Middleware\ErrorMiddleware;
use Slim\Psr7\Response;
use Slim\Views\TwigMiddleware;

$app->add(TwigMiddleware::createFromContainer($app));

$errorMiddleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    false,
    false
);

$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function ($request, $exception) use ($container) {
    $response = new Response();

    return $container->get('view')->render($response->withStatus(404), 'errors/404.twig');
});

$app->add($errorMiddleware);
