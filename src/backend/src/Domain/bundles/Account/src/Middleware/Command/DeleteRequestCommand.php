<?php
namespace Domain\Account\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Account\Exception\AccountHasDeleteRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteRequestCommand extends AbstractCommand
{
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
        } catch (AccountHasDeleteRequestException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}