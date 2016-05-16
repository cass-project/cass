<?php
namespace Domain\Account\Middleware\Command;

use Application\Command\Command;
use Application\REST\Response\ResponseBuilder;
use Domain\Account\Exception\InvalidOldPasswordException;
use Domain\Account\Middleware\Request\ChangePasswordRequest;
use Domain\Account\Service\AccountService;
use Domain\Auth\Service\CurrentAccountService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ChangePasswordCommand implements Command
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
        try {
            $account = $this->currentAccountService->getCurrentAccount();
            $parameters = (new ChangePasswordRequest($request))->getParameters();

            $newAPIKey = $this->accountService->changePassword($account, $parameters->old_password, $parameters->new_password);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'apiKey' => $newAPIKey
                ]);
        }catch(InvalidOldPasswordException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }

        return $responseBuilder->build();
    }
}