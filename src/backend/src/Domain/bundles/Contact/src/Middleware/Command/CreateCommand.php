<?php
namespace CASS\Domain\Bundles\Contact\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Contact\Exception\DuplicateContactException;
use CASS\Domain\Bundles\Contact\Middleware\Request\CreateContactRequest;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
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