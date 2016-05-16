<?php
namespace Domain\Account\Middleware\Command;

use Application\Command\Command;
use Application\REST\Response\ResponseBuilder;
use Domain\Account\Exception\AccountHasDeleleRequestException;
use Domain\Account\Service\AccountService;
use Domain\Auth\Service\CurrentAccountService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CancelDeleteRequestCommand implements Command
{
    /** @var AccountService */
    private $accountService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(AccountService $accountService, CurrentAccountService $currentAccountService)
    {
        $this->accountService = $accountService;
        $this->currentAccountService = $currentAccountService;
    }

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $account = $this->currentAccountService->getCurrentAccount();

        $this->accountService->cancelDeleteRequest($account);

        return $responseBuilder
            ->setStatusSuccess()
            ->build()
        ;
    }
}