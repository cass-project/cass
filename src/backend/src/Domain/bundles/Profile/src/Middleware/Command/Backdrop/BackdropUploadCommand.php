<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\UploadBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;
use CASS\Domain\Bundles\Colors\Repository\ColorsRepository;
use CASS\Domain\Bundles\Profile\Backdrop\Upload\ProfileBackdropUploadStrategyFactory;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use Psr\Http\Message\ServerRequestInterface;

final class BackdropUploadCommand extends UploadBackdropCommand
{
    use RunMixin;

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