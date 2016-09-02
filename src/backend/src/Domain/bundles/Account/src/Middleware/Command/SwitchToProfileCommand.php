<?php
namespace CASS\Domain\Account\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Account\Exception\AccountNotContainsProfileException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SwitchToProfileCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $account = $this->currentAccountService->getCurrentAccount();
        $profileId = $request->getAttribute('profileId');
        
        try {
            $this->accountService->switchToProfile($account, $profileId);

            $responseBuilder->setStatusSuccess()->setJson([
                'profile' => $account->getCurrentProfile()->toJSON()
            ]);
        }catch(AccountNotContainsProfileException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}