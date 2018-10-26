<?php declare (strict_types = 1);

namespace App\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Core\Database\DatabaseInterface;

class Controller
{
    /**
     * @var DatabaseInterface
     */
    protected $db;

    /**
     * @var Psr17Factory
     */
    protected $responseFactory;

    /**
     * Construct.
     *
     * @param DatabaseInterface $db
     * @param Psr17Factory $responseFactory
     */
    public function __construct(Psr17Factory $responseFactory)
    {
        $this->db = $db;
        $this->response = $responseFactory->createResponse();
    }
}
