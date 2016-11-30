<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\CollectionCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeCollectionService;

abstract class CollectionCommand extends Command
{
    protected $collectionService;
    protected $likeCollectionService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        CollectionService $collectionService,
        LikeCollectionService $likeCollectionService
    ){
        parent::__construct($currentAccountService);
        $this->collectionService = $collectionService;
        $this->likeCollectionService = $likeCollectionService;
    }

}