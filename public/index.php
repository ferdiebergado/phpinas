<?php declare (strict_types = 1);
/**
 * phpz - A fast PHP API framework using the Middleware Approach with PSR-Compliant Components
 *
 * @package  phpz
 * @author   Ferdinand Saporas Bergado <ferdiebergado@gmail.com>
 * MIT License

 * Copyright (c) 2018 Ferdinand Saporas Bergado

 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:

 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

/* FRONT CONTROLLER */

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__ . DS . '..' . DS);
define('CONFIG_PATH', BASE_PATH . 'config' . DS);
define('VENDOR_PATH', BASE_PATH . 'vendor' . DS);
define('DATE_FORMAT_SHORT', 'Y-m-d h:i:s');
define('DATE_FORMAT_LONG', 'Y-m-d h:i:s A e');

require VENDOR_PATH . 'autoload.php';

use Nyholm\Psr7\Response;
use Middlewares\FastRoute;
use Core\Container\Container;
use Northwoods\Broker\Broker;
use Middlewares\RequestHandler;
use function Http\Response\send;
use App\Controller\HomeController;
use Nyholm\Psr7\Factory\Psr17Factory;
use function FastRoute\simpleDispatcher;
use Nyholm\Psr7Server\ServerRequestCreator;

/* Register the error handler */
error_reporting(E_ALL);
$whoops = new Whoops\Run;
if (config('debug_mode')) {
    $whoops->pushHandler(new Whoops\Handler\JsonResponseHandler);
} else {
    $whoops->pushHandler(function ($e) use ($whoops) {
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
        $body = $whoops->handleException($e);
        // $app = require(CONFIG_PATH . 'app.php');
        // Core\Mail::send($app['author_email'], $app['name'] . ' Error Exception', $body);
        // logger($e->getMessage(), 2);
        // require VIEW_PATH . '500.php';
    });
}
// $whoops->register();

/* Create the Request and Response Objects */
$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
/** @var \Psr\Http\Message\ServerRequestInterface */
$request = $creator->fromGlobals();
$response = new Psr17Factory();

//Create the router dispatcher
$routes = simpleDispatcher(function (\FastRoute\RouteCollector $r) {
    $namespace = "App\\Controller\\";
    $r->addRoute('GET', '/hello/{name}', $namespace . 'HomeController::index');
});

/* Initialize the Dependency Injection Container */
// $container = new Container();

/* Build the Middleware Stack */
$broker = new Broker();
$broker->append(new FastRoute($routes, $response));
$broker->append(new RequestHandler());

/** @var \Psr\Http\Message\ResponseInterface */
$response = $broker->handle($request);

/* Send the response to the http client */
send($response->withHeader('Content-Type', 'application/json'));
