<?php
namespace CASS\Domain\Bundles\Contact\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ListCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profileId = (int) $request->getAttribute('profileId');

        try {
            $entities = $this->contactService->listContacts(
                $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId)
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