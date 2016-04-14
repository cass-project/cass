<?php
namespace EmailVerification\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class EmailVerificationMiddleware implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        return [];
    }
}