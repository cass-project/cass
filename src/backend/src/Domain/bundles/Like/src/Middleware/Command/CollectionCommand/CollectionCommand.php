<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\CollectionCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Formatter\CollectionFormatter;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeCollectionService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

abstract class CollectionCommand extends Command
{
    protected $collectionService;
    protected $likeCollectionService;
    protected $currentIPService;
    protected $collectionFormatter;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CollectionService $collectionService,
        LikeCollectionService $likeCollectionService,
        CurrentIPServiceInterface $currentIPService,
        CollectionFormatter $collectionFormatter
    ){
        parent::__construct($currentAccountService);
        $this->collectionService = $collectionService;
        $this->likeCollectionService = $likeCollectionService;
        $this->currentIPService = $currentIPService;
        $this->collectionFormatter = $collectionFormatter;
    }

}