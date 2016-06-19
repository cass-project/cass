<?php
namespace Domain\Account\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CancelDeleteRequestCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $account = $this->currentAccountService->getCurrentAccount();

        $this->accountService->cancelDeleteRequest($account);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}