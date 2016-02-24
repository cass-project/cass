<?php
namespace Auth\Middleware\Command;

use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;

class LogOutCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        throw new \Exception('Not implemented');
    }
}