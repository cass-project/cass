<?php
namespace Application\Command\Resolve\Resolvers;

use Application\Command\Command;
use DI\Container;
use Application\Command\Exception\UnresolvableCommandException;
use Application\Command\Resolve\CommandResolver;
use Psr\Http\Message\ServerRequestInterface;

final class DirectCommandResolver implements CommandResolver
{
    /** @var string */
    private $command;

    /** @var string */
    private $commandClassName;

    /** @var string|null */
    private $allowedMethod;

    public function __construct(string $command, string $commandClassName, string $allowedMethod = null) {
        $this->command = $command;
        $this->commandClassName = $commandClassName;
        $this->allowedMethod = strtolower($allowedMethod);
    }

    public function isResolvable(ServerRequestInterface $request) {
        if($this->allowedMethod) {
            if($this->allowedMethod !== strtolower($request->getMethod())) {
                return false;
            }
        }

        return $request->getAttribute('command') === $this->command;
    }

    public function resolve(ServerRequestInterface $request, Container $container): Command {
        if(! $this->isResolvable($request)) {
            throw new UnresolvableCommandException;
        }
        
        return $container->get($this->commandClassName);
    }
}