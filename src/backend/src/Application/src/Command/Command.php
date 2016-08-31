<?php
namespace CASS\Application\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface;
}