<?php
namespace CASS\Domain\Bundles\Community\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Exception\BackdropUploadException;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Exception\CommunityNotFoundException;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

trait BackdropCommandMixin
{
    /** @var Community */
    private $entity;

    /** @var BackdropService */
    private $backdropService;

    /** @var CommunityService */
    private $communityService;

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
        }catch(CommunityNotFoundException $e) {
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
        if($entity instanceof Community) {
            $this->communityService->updateBackdrop($entity);
        }else{
            throw new \Exception('Invalid entity: unable to save entity');
        }
    }

    protected function getBackdropAwareEntity(ServerRequestInterface $request): BackdropEntityAware
    {
        if(! $this->entity) {
            $this->entity = $this->communityService->getCommunityById($request->getAttribute('communityId'));
        }

        return $this->entity;
    }

    protected function getBackdropService(): BackdropService
    {
        return $this->backdropService;
    }
}