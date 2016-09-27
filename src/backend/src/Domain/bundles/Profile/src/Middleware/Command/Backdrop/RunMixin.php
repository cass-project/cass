<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Exception\BackdropUploadException;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

trait RunMixin
{
    /** @var Profile */
    private $entity;

    /** @var BackdropService */
    private $backdropService;

    /** @var ProfileService */
    private $profileService;

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
        }catch(ProfileNotFoundException $e) {
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
        if($entity instanceof Profile) {
            $this->profileService->saveProfile($entity);
        }else{
            throw new \Exception('Invalid entity: unable to save entity');
        }
    }

    protected function getBackdropAwareEntity(ServerRequestInterface $request): BackdropEntityAware
    {
        if(! $this->entity) {
            $this->entity = $this->profileService->getProfileById($request->getAttribute('profileId'));
        }

        return $this->entity;
    }

    protected function getBackdropService(): BackdropService
    {
        return $this->backdropService;
    }
}