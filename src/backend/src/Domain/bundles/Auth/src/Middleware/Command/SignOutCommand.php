<?php
namespace Domain\Auth\Middleware\Command;

use Application\REST\Response\GenericResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;

class SignOutCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericResponseBuilder $responseBuilder)
    {
        $this->getAuthService()->signOut();
        
        $responseBuilder->setStatusSuccess();
    }
}