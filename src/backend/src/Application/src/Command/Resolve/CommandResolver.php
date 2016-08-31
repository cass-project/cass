<?php
namespace CASS\Application\Command\Resolve;

use CASS\Application\Command\Command;
use DI\Container;
use Psr\Http\Message\ServerRequestInterface;

interface CommandResolver
{
    public function isResolvable(ServerRequestInterface $request): bool;
    public function resolve(ServerRequestInterface $request, Container $container): Command;
}