<?php
namespace CASS\Domain\Collection\Middleware\Command;

use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Collection\Service\CollectionService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var CollectionService */
    protected $collectionService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    public function __construct(
        CollectionService $collectionService,
        CurrentAccountService $currentAccountService
    )
    {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
    }
}