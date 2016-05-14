<?php
namespace Application\Service;

use Application\Command\Resolve\CommandResolverBuilder;
use DI\Container;

class CommandService
{
    /** @var Container */
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function createResolverBuilder(): CommandResolverBuilder {
        return new CommandResolverBuilder($this->container);
    }
}
