<?php
namespace CASS\Domain\Account\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Account\Exception\InvalidOldPasswordException;
use CASS\Domain\Account\Middleware\Request\ChangePasswordRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ChangePasswordCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $account = $this->currentAccountService->getCurrentAccount();
            $parameters = (new ChangePasswordRequest($request))->getParameters();

            $newAPIKey = $this->accountService->changePassword($account, $parameters['old_password'], $parameters['new_password']);

            $this->authService->auth($account);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'apiKey' => $newAPIKey
                ]);
        } catch (InvalidOldPasswordException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }

        return $responseBuilder->build();
    }
}