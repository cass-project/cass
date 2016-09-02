<?php
namespace CASS\Domain\Account\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Account\Exception\AccountHasDeleteRequestException;
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
                    'date_account_delete_request' => $account->getDateAccountDeleteRequested()->format(\DateTime::RFC2822)
                ]);
        } catch (AccountHasDeleteRequestException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}