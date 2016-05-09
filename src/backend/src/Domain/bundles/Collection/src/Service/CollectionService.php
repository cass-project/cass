<?php
namespace Domain\Collection\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Repository\CollectionRepository;

class CollectionService
{
    /** @var CollectionRepository */
    private $collectionRepository;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CollectionRepository $collectionRepository, CurrentAccountService $currentAccountService)
    {
        $this->collectionRepository = $collectionRepository;
        $this->currentAccountService = $currentAccountService;
    }
}