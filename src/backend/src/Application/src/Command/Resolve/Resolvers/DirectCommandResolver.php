<?php
namespace CASS\Application\Command\Resolve\Resolvers;

use CASS\Application\Command\Command;
use DI\Container;
use CASS\Application\Command\Exception\UnresolvableCommandException;
use CASS\Application\Command\Resolve\CommandResolver;
use Psr\Http\Message\ServerRequestInterface;

final class DirectCommandResolver implements CommandResolver
{
    /** @var string */
    private $command;

    /** @var string */
    private $commandClassName;

    /** @var string|null */
    private $allowedMethod;

    /** @var string */
    private $attr;

    public function __construct(string $command, string $commandClassName, string $allowedMethod = null, string $attr = 'command') {
        $this->command = $command;
        $this->commandClassName = $commandClassName;
        $this->allowedMethod = strtolower($allowedMethod);
        $this->attr = $attr;
    }

    public function isResolvable(ServerRequestInterface $request): bool {
        if($this->allowedMethod) {
            if($this->allowedMethod !== strtolower($request->getMethod())) {
                return false;
            }
        }
        
        return $request->getAttribute($this->attr) === $this->command;
    }

    public function resolve(ServerRequestInterface $request, Container $container): Command {
        if(! $this->isResolvable($request)) {
            throw new UnresolvableCommandException;
        }
        
        return $container->get($this->commandClassName);
    }
}