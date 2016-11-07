<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class SubscribeCollectionCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $collection = $this->collectionService->getCollectionById($request->getAttribute('collectionId'));

            $entity = $this->subscribeService->subscribeCollection($currentProfile, $collection);

            $responseBuilder
                ->setJson([
                    'entity' => $entity->toJSON(),
                ])
                ->setStatusSuccess();
        } catch (CollectionNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}