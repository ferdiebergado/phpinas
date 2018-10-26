<?php declare (strict_types = 1);

namespace App\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Controller\AbstractController;

class HomeController
{
    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [
            'data' => 'Welcome ' . $request->getAttribute('name')
        ];
        $response = new Response();
        $response->getBody()->write(jsonize($data));
        return $response;
    }

    public function debug(ServerRequestInterface $request) : ResponseInterface
    {

        // return $response
    }
}
