<?php declare (strict_types = 1);

namespace Core\Database;

use ParagonIE\EasyDB\EasyDB;
use Core\Database\DatabaseInterface;
use PDO;

class Database extends EasyDB implements DatabaseInterface
{
    /**
     * @param PDO $pdo
     * @param string $driver
     */
    public function __construct(PDO $pdo, $driver)
    {
        parent::__construct($pdo, $driver);
    }

    // protected function connect() : PDO
    // {
    //     $dsn = getenv('DB_DRIVER') . ":host=" . getenv('DB_HOST') . ";port=" . getenv('DB_PORT') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8mb4";
    //     return new PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'));
    // }
}
