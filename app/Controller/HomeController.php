<?php declare (strict_types = 1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use App\Controller\Controller;

class HomeController extends Controller
{
    public function index(ServerRequestInterface $request) : ResponseInterface
    {
        $data = [
            'data' => 'Welcome ' . $request->getAttribute('name')
        ];
        $this->response->getBody()->write(jsonize($data));
        return $this->response;
    }
}
