<?php
namespace Profile\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Profile\Middleware\Command\Command;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileMiddleware implements MiddlewareInterface
{

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);
        $command = Command::factory($request);
        $json = $command->run($request);
        return $responseBuilder
            ->setStatusSuccess()
            ->setJson($json)
            ->build()
        ;
    }
}