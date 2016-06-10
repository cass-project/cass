<?php
namespace Domain\Collection\Middleware\Command;

use Domain\Collection\Service\CollectionService;
use Application\Exception\CommandNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command implements \Application\Command\Command
{
    /** @var CollectionService */
    protected $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }
}