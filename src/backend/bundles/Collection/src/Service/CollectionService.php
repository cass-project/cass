<?php
namespace Collection\Service;

use Auth\Service\CurrentAccountService;
use Collection\Repository\CollectionRepository;

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