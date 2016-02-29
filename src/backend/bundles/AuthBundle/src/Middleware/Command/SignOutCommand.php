<?php
namespace Auth\Middleware\Command;

use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;

class SignOutCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        $this->getAuthService()->signOut();
        $responseBuilder->setStatusSuccess();
    }
}