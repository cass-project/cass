<?php
namespace Domain\Contact\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Contact\Entity\Contact;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = $request->getAttribute('profileId');

        try {
            $entities = $this->contactService->listContacts(
                $this->currentAccountService->getProfileWithId($profileId)
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entities' => $this->contactFormatter->formatMany($entities)
                ]);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}