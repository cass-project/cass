<?php
namespace Domain\Contact\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Contact\Exception\ContactNotFoundException;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SetPermanentCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = $request->getAttribute('profileId');
        $contactId = $request->getAttribute('contactId');

        try {
            $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId);

            $contact = $this->contactService->setPermanentContact($contactId);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $this->contactFormatter->format($contact)
                ])
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