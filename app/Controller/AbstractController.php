<?php declare (strict_types = 1);

namespace App\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;

abstract class AbstractController
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    public function __construct()
    {
        $this->response = (new Psr17Factory())->createResponse();
    }
}
