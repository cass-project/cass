<?php
namespace CASS\Domain\Contact\Middleware\Command;

use CASS\Domain\Profile\Exception\ProfileNotFoundException;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Contact\Exception\ContactNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = $request->getAttribute('profileId');
        $contactId = $request->getAttribute('contactId');

        try {
            $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId);
            $this->contactService->deleteContact($contactId);

            $responseBuilder->setStatusSuccess();
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }catch(ContactNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}