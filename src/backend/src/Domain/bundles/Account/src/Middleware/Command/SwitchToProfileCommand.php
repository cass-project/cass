<?php
namespace Domain\Account\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Account\Exception\AccountNotContainsProfileException;
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