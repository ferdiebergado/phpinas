<?php declare (strict_types = 1);

namespace App\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeController
{
    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [
            'data' => 'Welcome ' . $request->getAttribute('name')
        ];
        $response = new Response();
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        return $response;
    }
}
