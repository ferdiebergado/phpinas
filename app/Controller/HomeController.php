<?php declare (strict_types = 1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

class HomeController
{
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [
            'data' => 'Welcome ' . $request->getAttribute('name')
        ];
        $response = (new Psr17Factory())->createResponse();
        $response->getBody()->write(jsonize($data));
        return $response;
    }

    public function debug(ServerRequestInterface $request) : ResponseInterface
    {

        // return $response
    }
}
