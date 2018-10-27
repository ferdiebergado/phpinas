<?php

use App\Controller\AuthController;
use Core\Database\DatabaseInterface;
use Core\Database\EasydbDatabase;
use App\Controller\HomeController;
use App\Controller\Controller;
use Nyholm\Psr7\Factory\Psr17Factory;

$builder = new DI\ContainerBuilder();
$builder->enableCompilation(CORE_PATH . 'Container');
$dsn = getenv('DB_DRIVER') . ":host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8mb4";
$builder->addDefinitions([
    Psr17Factory::class => DI\create(),
    'psr17factory' => DI\get(Psr17Factory::class),
    Controller::class => DI\create()->constructor(DI\get('psr17factory')),
    HomeController::class => DI\autowire(),
    AuthController::class => DI\autowire()->constructor(DI\get(DatabaseInterface::class), DI\get('psr17factory')),
    DatabaseInterface::class => DI\create(EasydbDatabase::class)->constructor(DI\create(PDO::class)->constructor($dsn, DI\env('DB_USER'), DI\env('DB_PASS'), null))
]);
$container = $builder->build();

return $container;
