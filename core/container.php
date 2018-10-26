<?php

use League\Container\Definition\Definition;
use App\Controller\HomeController;
use App\Controller\AuthController;
use Core\Database\DatabaseInterface;
use Core\Database\Database;

$dsn = getenv('DB_DRIVER') . ":host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8mb4";

$definitions = [
    new Definition(HomeController::class),
    (new Definition(AuthController::class))->addMethodCall('setDatabase', [DatabaseInterface::class]),
    new Definition(DatabaseInterface::class, Database::class),
    (new Definition(Database::class))->addArguments([PDO::class, getenv('DB_DRIVER')]),
    (new Definition(PDO::class))->addArguments([$dsn, getenv('DB_USER'), getenv('DB_PASS')])->setShared(),
];

$aggregate = new League\Container\Definition\DefinitionAggregate($definitions);
$container = new League\Container\Container($aggregate);

return $container;
