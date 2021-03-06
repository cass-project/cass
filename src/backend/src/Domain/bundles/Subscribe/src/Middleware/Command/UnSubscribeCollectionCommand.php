<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Subscribe\Exception\UnknownSubscribeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class UnSubscribeCollectionCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $collection = $this->collectionService->getCollectionById($request->getAttribute('collectionId'));

            $this->subscribeService->unSubscribeCollection($currentProfile, $collection);

            $responseBuilder
                ->setStatusSuccess();
        } catch (UnknownSubscribeException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        } catch (CollectionNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}