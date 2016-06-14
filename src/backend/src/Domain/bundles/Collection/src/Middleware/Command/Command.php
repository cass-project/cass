<?php
namespace Domain\Collection\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Service\CollectionService;
use Application\Exception\CommandNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command implements \Application\Command\Command
{
    /** @var CollectionService */
    protected $collectionService;

    /** @var CurrentAccountService */
    protected $currentAccountService;

    public function __construct(
        CollectionService $collectionService,
        CurrentAccountService $currentAccountService
    ) {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
    }
}