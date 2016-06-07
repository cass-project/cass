<?php
namespace Application\Command\Resolve\Resolvers;

use DI\Container;
use Application\Command\Exception\UnresolvableCommandException;
use Application\Command\Command;
use Application\Command\Resolve\CommandResolver;
use Psr\Http\Message\ServerRequestInterface;

final class CallbackCommandResolver implements CommandResolver
{
    /** @var Callable */
    private $callback;

    /** @var string */
    private $commandClassName;

    public function __construct(Callable $callback, string $commandClassName) {
        $this->callback = $callback;
        $this->commandClassName = $commandClassName;
    }


    public function isResolvable(ServerRequestInterface $request): bool {
        $c = $this->callback;

        return $c($request);
    }

    public function resolve(ServerRequestInterface $request, Container $container): Command {
        if(! $this->isResolvable($request)) {
            throw new UnresolvableCommandException;
        }

        return $container->get($this->commandClassName);
    }
}