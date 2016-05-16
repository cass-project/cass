<?php
namespace Application\Command\Resolve\Resolvers;

use Application\Command\Command;
use Application\Command\Exception\UnresolvableCommandException;
use Application\Command\Resolve\CommandResolver;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;

final class CompositionCommandResolver implements CommandResolver
{
    /** @var CommandResolver[] */
    private $resolvers = [];

    public function attachResolver(CommandResolver $commandResolver) {
        $this->resolvers[] = $commandResolver;
    }

    public function detachResolver(CommandResolver $commandResolver) {
        $this->resolvers = array_filter($this->resolvers, function(CommandResolver $compare) use ($commandResolver) {
            return $commandResolver !== $compare;
        });
    }

    public function isResolvable(ServerRequestInterface $request) {
        foreach($this->resolvers as $commandResolver) {
            if($commandResolver->isResolvable($request)) {
                return true;
            }
        }

        return false;
    }

    public function resolve(ServerRequestInterface $request, Container $container): Command {
        foreach ($this->resolvers as $commandResolver) {
            if($commandResolver->isResolvable($request)) {
                return $commandResolver->resolve($request, $container);
            }
        }

        throw new UnresolvableCommandException('Request is unresolvable');
    }
}