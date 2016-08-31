<?php
namespace Domain\Account\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetCurrentAccountCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $responseBuilder->setStatusSuccess()->setJson([
            'account' => $this->currentAccountService->getCurrentAccount()->toJSON()
        ]);
    }
}