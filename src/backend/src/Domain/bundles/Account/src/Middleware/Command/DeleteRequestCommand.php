<?php
namespace Domain\Account\Middleware\Command;

use Application\Command\Command;
use Application\REST\Response\ResponseBuilder;
use Domain\Account\Exception\AccountHasDeleleRequestException;
use Domain\Account\Service\AccountService;
use Domain\Auth\Service\CurrentAccountService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteRequestCommand implements Command
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

        try {
            $this->accountService->requestDelete($account);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'date_account_delete_request' => $account->getDateAccountDeleteRequested()->format(\DateTime::RFC822)
                ]);
        }catch(AccountHasDeleleRequestException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}