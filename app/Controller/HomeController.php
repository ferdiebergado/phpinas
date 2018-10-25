<?php declare (strict_types = 1);

namespace App\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [
            'data' => 'Welcome ' . $request->getAttribute('name')
        ];
        // $response = new Response();
        $this->response->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        return $this->response;
    }

    public function debug(ServerRequestInterface $request) : ResponseInterface
    {

        // return $response
    }
}
