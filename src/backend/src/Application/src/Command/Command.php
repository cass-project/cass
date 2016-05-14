<?php
namespace Application\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

interface Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response;
}