<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Exception\BackdropUploadException;
use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\UploadBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;
use CASS\Domain\Bundles\Colors\Repository\ColorsRepository;
use CASS\Domain\Bundles\Profile\Backdrop\Upload\ProfileBackdropUploadStrategyFactory;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

final class BackdropUploadCommand extends UploadBackdropCommand
{
    /** @var Profile */
    private $entity;

    /** @var BackdropService */
    private $backdropService;

    /** @var ProfileService */
    private $profileService;

    /** @var ColorsRepository */
    private $colorRepository;

    /** @var ProfileBackdropUploadStrategyFactory */
    private $strategyFactory;

    public function __construct(
        BackdropService $backdropService,
        ProfileService $profileService,
        ColorsRepository $colorRepository,
        ProfileBackdropUploadStrategyFactory $strategyFactory
    ) {
        $this->backdropService = $backdropService;
        $this->profileService = $profileService;
        $this->colorRepository = $colorRepository;
        $this->strategyFactory = $strategyFactory;
    }

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $backdrop = $this->upload($request);

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

    protected function saveBackdropAwareEntityChanges(BackdropEntityAware $entity)
    {
        if($entity instanceof Profile) {
            $this->profileService->saveProfile($entity);
        }else{
            throw new \Exception('Invalid entity: unable to save entity');
        }
    }

    protected function getColorRepository(): ColorsRepository
    {
        return $this->colorRepository;
    }

    protected function getBackdropUploadStrategy(ServerRequestInterface $request, BackdropEntityAware $entity): BackdropUploadStrategy
    {
        if($entity instanceof Profile) {
            return $this->strategyFactory->createStreategyFor($entity);
        }else{
            throw new \Exception('Invalid entity: unable to create strategy');
        }
    }
}