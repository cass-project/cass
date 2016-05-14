<?php
namespace Application\Command\Resolve;

use Application\Command\Command;
use Application\Command\Resolve\CommandResolver;
use Application\Command\Resolve\Resolvers\CompositionCommandResolver;
use Application\Command\Resolve\Resolvers\DirectCommandResolver;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;

class CommandResolverBuilder
{
    /** @var CompositionCommandResolver */
    private $composition;

    /** @var Container */
    private $container;

    public function __construct(Container $container) {
        $this->composition = new CompositionCommandResolver();
        $this->container = $container;
    }

    public function attachDirect(string $command, string $commandClassName, string $allowedMethod = null): self {
        $this->composition->attachResolver(new DirectCommandResolver($command, $commandClassName, $allowedMethod));

        return $this;
    }

    public function getCommandResolver(): CommandResolver
    {
        return $this->composition;
    }

    public function resolve(ServerRequestInterface $request): Command
    {
        return $this->composition->resolve($request, $this->container);
    }
}