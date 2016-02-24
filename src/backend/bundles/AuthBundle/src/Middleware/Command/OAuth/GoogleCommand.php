<?php
namespace Auth\Middleware\Command\OAuth;

use Auth\Middleware\Command\Command;

class GoogleCommand extends Command
{
    public function run(ServerRequestInterface $request, RESTResponseBuilder $responseBuilder)
    {
        $request = $this->request;
        $responseBuilder = $this->responseBuilder;
    }
}