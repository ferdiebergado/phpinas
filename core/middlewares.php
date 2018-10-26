<?php

use function Fastroute\simpleDispatcher;
use Nyholm\Psr7\Factory\Psr17Factory;
use Northwoods\Broker\Broker;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;

//Create the router dispatcher
$router = simpleDispatcher(function (\FastRoute\RouteCollector $r) {
    $namespace = "App\\Controller\\";
    $routes = include_once(CONFIG_PATH . 'routes.php');
    foreach ($routes as $route) {
        $r->addRoute($route[0], $route[1], [$namespace . $route[2][0], $route[2][1]]);
    }
});

$responseFactory = new Psr17Factory();

/* Initialize the Dependency Injection Container */
$container = require(CORE_PATH . 'container.php');

$broker = new Broker();
$broker->append(new FastRoute($router, $responseFactory));
$broker->append(new RequestHandler($container));
return $broker;
