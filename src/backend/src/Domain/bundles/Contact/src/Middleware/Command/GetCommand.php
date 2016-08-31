<?php
namespace Domain\Contact\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Domain\Contact\Exception\ContactNotFoundException;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class GetCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = $request->getAttribute('profileId');
        $contactId = $request->getAttribute('contactId');

        try {
            $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId);

            $responseBuilder
                ->setJson([
                    'entity' => $this->contactFormatter->format(
                        $this->contactService->getContactById($contactId)
                    )
                ])
                ->setStatusSuccess()
            ;
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