<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Northwoods\Broker\Broker;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;

$router = require(CORE_PATH . 'router.php');

$responseFactory = new Psr17Factory();

/* Initialize the Dependency Injection Container */
$container = require(CORE_PATH . 'Container' . DS . 'container.php');

$broker = new Broker();
$broker->append(new FastRoute($router, $responseFactory));
$broker->append(new Tuupola\Middleware\JwtAuthentication([
    "path" => ["/auth", "/hello"],
    "secure" => true,
    "relaxed" => ["localhost:8787"],    
    "ignore" => ["/auth/login"],    
    'secret' => getenv('JWT_SECRET')
]));
$broker->append(new RequestHandler($container));

return $broker;
