<?php


namespace Domain\PostReport\Middleware;


use Domain\PostReport\Middleware\Command\Command;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostReportMiddleware implements MiddlewareInterface
{
  public function __invoke(Request $request, Response $response, callable $out = NULL){



  }

}