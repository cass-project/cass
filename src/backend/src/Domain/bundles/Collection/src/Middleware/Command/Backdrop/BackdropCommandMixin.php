<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Exception\BackdropUploadException;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

trait BackdropCommandMixin
{
    /** @var Collection */
    private $entity;

    /** @var BackdropService */
    private $backdropService;

    /** @var CollectionService */
    private $collectionService;

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            /** @var Backdrop $backdrop */
            $backdrop = $this->perform($request);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'backdrop' => $backdrop->toJSON(),
                ]);
        }catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }catch(BackdropUploadException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        }

        return $responseBuilder->build();
    }

    protected function saveBackdropAwareEntityChanges(BackdropEntityAware $entity)
    {
        if($entity instanceof Collection) {
            $this->collectionService->updateBackdrop($entity);
        }else{
            throw new \Exception('Invalid entity: unable to save entity');
        }
    }

    protected function getBackdropAwareEntity(ServerRequestInterface $request): BackdropEntityAware
    {
        if(! $this->entity) {
            $this->entity = $this->collectionService->getCollectionById($request->getAttribute('collectionId'));
        }

        return $this->entity;
    }

    protected function getBackdropService(): BackdropService
    {
        return $this->backdropService;
    }
}