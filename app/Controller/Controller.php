<?php declare (strict_types = 1);

namespace App\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;

class Controller
{
    /**
     * @var Psr17Factory
     */
    protected $response;

    public function __construct(Psr17Factory $responseFactory)
    {
        $this->response = $responseFactory->createResponse();
    }
}
