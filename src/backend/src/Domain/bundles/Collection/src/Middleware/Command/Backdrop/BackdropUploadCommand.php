<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Middleware\AbstractCommands\UploadBackdropCommand;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;
use CASS\Domain\Bundles\Collection\Backdrop\Upload\CollectionBackdropUploadStrategyFactory;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use Psr\Http\Message\ServerRequestInterface;

final class BackdropUploadCommand extends UploadBackdropCommand
{
    use BackdropCommandMixin;

    /** @var CollectionBackdropUploadStrategyFactory */
    private $strategyFactory;

    public function __construct(
        BackdropService $backdropService,
        CollectionService $collectionService,
        CollectionBackdropUploadStrategyFactory $uploadStrategyFactory
    ) {
        $this->backdropService = $backdropService;
        $this->collectionService = $collectionService;
        $this->strategyFactory = $uploadStrategyFactory;
    }

    protected function getBackdropUploadStrategy(ServerRequestInterface $request, BackdropEntityAware $entity): BackdropUploadStrategy
    {
        if($entity instanceof Collection) {
            return $this->strategyFactory->createStrategyFor($entity);
        }else{
            throw new \Exception('Invalid entity: unable to create strategy');
        }
    }
}