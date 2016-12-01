<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\CollectionCommand;

use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class AddLikeCollectionCommand extends CollectionCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $collectionId = $request->getAttribute('collectionId');
            $collection = $this->collectionService->getCollectionById($collectionId);

            $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($collection);

            $this->likeCollectionService->addLike($collection, $attitude);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $collection->toJSON(),
                ]);

        } catch(AttitudeAlreadyExistsException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusConflict();
        } catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        } catch(\Exception $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }

}