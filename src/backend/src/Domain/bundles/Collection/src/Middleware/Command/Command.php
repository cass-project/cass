<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Formatter\CollectionFormatter;
use CASS\Domain\Bundles\Collection\Service\CollectionService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var CollectionService */
    protected $collectionService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var CollectionFormatter */
    protected $collectionFormatter;

    public function __construct(
        CollectionService $collectionService,
        CurrentAccountService $currentAccountService,
        CollectionFormatter $collectionFormatter
    )
    {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
        $this->collectionFormatter = $collectionFormatter;
    }
}