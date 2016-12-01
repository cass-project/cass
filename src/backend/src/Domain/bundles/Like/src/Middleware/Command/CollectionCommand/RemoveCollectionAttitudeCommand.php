<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\CollectionCommand;

use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class RemoveCollectionAttitudeCommand extends CollectionCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $collectionId = $request->getAttribute('collectionId');
            $collection = $this->collectionService->getCollectionById($collectionId);

            // устанавливаем владельца
            $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($collection);

            // устанавливаем свойства
            $attitude->setResource($collection);
            $attitude = $this->likeCollectionService->getAttitude($attitude);

            switch($attitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_LIKE:
                    $this->likeCollectionService->removeLike($collection, $attitude);
                    break;
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    $this->likeCollectionService->removeDislike($collection, $attitude);
                    break;
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $collection->toJSON(),
                ]);

        } catch(AttitudeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
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