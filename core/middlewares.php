<?php
/* THE MIDDLEWARE STACK */

$router = require(CORE_PATH . 'router.php');

$responseFactory = new Nyholm\Psr7\Factory\Psr17Factory();

$jwtconfig = require(CONFIG_PATH . 'auth.php');

/* Initialize the Dependency Injection Container */
$container = require(CORE_PATH . 'Container' . DS . 'container.php');

$broker = new Northwoods\Broker\Broker();
$broker->append(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    "headers.allow" => ["Content-Type", "Authorization", "If-Match", "If-Unmodified-Since"],
    "headers.expose" => ["Etag"],
    "credentials" => true,
    "cache" => 86400
]));
// $broker->append((new Middlewares\Cors($analyzer))->responseFactory($responseFactory));
$broker->append(new Middlewares\FastRoute($router, new Nyholm\Psr7\Factory\Psr17Factory));
$broker->append(new Tuupola\Middleware\JwtAuthentication($jwtconfig));
$broker->append(new Middlewares\RequestHandler($container));

return $broker;
