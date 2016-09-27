<?php
namespace CASS\Domain\Bundles\Community\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\UploadBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;
use CASS\Domain\Bundles\Community\Backdrop\Upload\CommunityBackdropUploadStrategyFactory;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use Psr\Http\Message\ServerRequestInterface;

final class BackdropUploadCommand extends UploadBackdropCommand
{
    use BackdropCommandMixin;

    /** @var CommunityBackdropUploadStrategyFactory */
    private $strategyFactory;

    public function __construct(
        BackdropService $backdropService,
        CommunityService $communityService,
        CommunityBackdropUploadStrategyFactory $uploadStrategyFactory
    ) {
        $this->backdropService = $backdropService;
        $this->communityService = $communityService;
        $this->strategyFactory = $uploadStrategyFactory;
    }

    protected function getBackdropUploadStrategy(ServerRequestInterface $request, BackdropEntityAware $entity): BackdropUploadStrategy
    {
        if($entity instanceof Community) {
            return $this->strategyFactory->createStrategyFor($entity);
        }else{
            throw new \Exception('Invalid entity: unable to create strategy');
        }
    }
}