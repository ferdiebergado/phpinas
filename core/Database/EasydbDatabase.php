<?php declare (strict_types = 1);

namespace Core\Database;

use ParagonIE\EasyDB\EasyDB;
use Core\Database\DatabaseInterface;
use PDO;

class EasydbDatabase extends EasyDB implements DatabaseInterface
{
    /**
     * Construct.
     * 
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo, getenv('DB_DRIVER'));
    }

}
