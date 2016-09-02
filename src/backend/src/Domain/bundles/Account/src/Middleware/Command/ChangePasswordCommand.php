<?php
namespace CASS\Domain\Bundles\Account\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Account\Exception\InvalidOldPasswordException;
use CASS\Domain\Bundles\Account\Middleware\Request\ChangePasswordRequest;
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