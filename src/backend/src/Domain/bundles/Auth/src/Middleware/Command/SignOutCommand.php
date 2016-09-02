<?php
namespace CASS\Domain\Auth\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SignOutCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        $this->authService->signOut();

        return $responseBuilder
            ->setStatusSuccess()
            ->build()
        ;
    }
}