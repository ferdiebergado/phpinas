<?php

/*** MIDDLEWARE STACK ***/

/* Middleware Dispatcher */
$broker = new Northwoods\Broker\Broker();

/* Content-Type Negotiation */
$broker->append((new Middlewares\ContentType([
    'json' => [
        'extension' => ['json'],
        'mime-type' => ['application/json'],
        'charset' => true,
    ]
]))->useDefault(false));
        
/* CORS */
$corsconfig = require(CONFIG_PATH . "cors.php");
$broker->append(new Tuupola\Middleware\CorsMiddleware($corsconfig));
            
/* Json Payload */
$broker->append(new Middlewares\JsonPayload());
            
/* Router */
$router = require(CORE_PATH . 'router.php');
$broker->append(new Middlewares\FastRoute($router, new Nyholm\Psr7\Factory\Psr17Factory));
            
/* JWT Authentication */
$jwtconfig = require(CONFIG_PATH . 'auth.php');
$broker->append(new Tuupola\Middleware\JwtAuthentication($jwtconfig));
            
/* Request Handler */
$container = require(CORE_PATH . 'Container' . DS . 'container.php');
$broker->append(new Middlewares\RequestHandler($container));

return $broker;
