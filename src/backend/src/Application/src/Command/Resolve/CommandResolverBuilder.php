<?php
namespace CASS\Application\Command\Resolve;

use CASS\Application\Command\Command;
use CASS\Application\Command\Resolve\Resolvers\CallbackCommandResolver;
use CASS\Application\Command\Resolve\Resolvers\CompositionCommandResolver;
use CASS\Application\Command\Resolve\Resolvers\DirectCommandResolver;
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

    public function attachDirect(string $command, string $commandClassName, string $allowedMethod = null, string $attr = 'command'): self {
        $this->composition->attachResolver(new DirectCommandResolver($command, $commandClassName, $allowedMethod, $attr));

        return $this;
    }

    public function attachCallable(Callable $callback, string $commandClassName): self {
        $this->composition->attachResolver(new CallbackCommandResolver($callback, $commandClassName));

        return $this;
    }

    public function getCommandResolver(): CompositionCommandResolver
    {
        return $this->composition;
    }

    public function resolve(ServerRequestInterface $request): Command
    {
        return $this->composition->resolve($request, $this->container);
    }
}