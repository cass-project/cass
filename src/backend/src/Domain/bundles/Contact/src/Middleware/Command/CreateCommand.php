<?php
namespace CASS\Domain\Contact\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Contact\Exception\DuplicateContactException;
use CASS\Domain\Contact\Middleware\Request\CreateContactRequest;
use CASS\Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = $request->getAttribute('profileId');
        $parameters = (new CreateContactRequest($request))->getParameters();
        
        try {
            $entity = $this->contactService->createContact(
                $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId),
                $parameters
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $this->contactFormatter->format($entity)
                ]);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }catch(DuplicateContactException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}