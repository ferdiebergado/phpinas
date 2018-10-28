<?php declare (strict_types = 1);
/**
 * phpinas - A fast PHP API framework using the Middleware Approach with PSR-Compliant Components
 *
 * @package  phpinas
 * @author   Ferdinand Saporas Bergado <ferdiebergado@gmail.com>
 * MIT License
 */

/* FRONT CONTROLLER */

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__ . DS . '..' . DS);
define('VENDOR_PATH', BASE_PATH . 'vendor' . DS);
define('CONFIG_PATH', BASE_PATH . 'config' . DS);
define('CORE_PATH', BASE_PATH . 'core' . DS);
define('DATE_FORMAT_SHORT', 'Y-m-d h:i:s');
define('DATE_FORMAT_LONG', 'Y-m-d h:i:s A e');

require VENDOR_PATH . 'autoload.php';

// create a log channel
$logger = new Monolog\Logger('logger');
$logger->pushHandler(new Monolog\Handler\StreamHandler(BASE_PATH . 'app.log', Monolog\Logger::DEBUG));

/* Register the error handler */
error_reporting(E_ALL);
$whoops = new Whoops\Run;
if (config('debug_mode')) {
    $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler);
} else {
    $whoops->pushHandler(function ($e) use ($whoops, $logger) {
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new Whoops\Handler\PlainTextHandler);
        $body = $whoops->handleException($e);
        $logger->addError($body);
        // $app = require(CONFIG_PATH . 'app.php');
        // Core\Mail::send($app['author_email'], $app['name'] . ' Error Exception', $body);
        // logger($e->getMessage(), 2);
        // require VIEW_PATH . '500.php';
    });
}
$whoops->register();

/* Load the environment variables */
$dotenv = new Dotenv\Dotenv(BASE_PATH);
$dotenv->load();

/* Create the Request Object */
$psr17Factory = new Nyholm\Psr7\Factory\Psr17Factory();
$creator = new Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
/** @var \Psr\Http\Message\ServerRequestInterface */
$request = $creator->fromGlobals();

/* Build the Middleware Stack */
$broker = require(CORE_PATH . 'middlewares.php');

/* Dispatch the Middlewares */
/** @var \Psr\Http\Message\ResponseInterface */
$response = $broker->handle($request);

/* Send the response to the http client */
Http\Response\send($response);
