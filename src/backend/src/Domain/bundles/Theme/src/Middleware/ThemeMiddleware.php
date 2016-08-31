<?php
namespace Domain\Theme\Middleware;

use CASS\Application\Service\CommandService;
use CASS\Application\REST\Response\GenericResponseBuilder;
use Domain\Theme\Middleware\Command\CreateCommand;
use Domain\Theme\Middleware\Command\DeleteCommand;
use Domain\Theme\Middleware\Command\GetCommand;
use Domain\Theme\Middleware\Command\ListAllCommand;
use Domain\Theme\Middleware\Command\MoveCommand;
use Domain\Theme\Middleware\Command\TreeCommand;
use Domain\Theme\Middleware\Command\UpdateCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ThemeMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('create', CreateCommand::class)
            ->attachDirect('delete', DeleteCommand::class)
            ->attachDirect('get', GetCommand::class)
            ->attachDirect('list-all', ListAllCommand::class)
            ->attachDirect('move', MoveCommand::class)
            ->attachDirect('tree', TreeCommand::class)
            ->attachDirect('update', UpdateCommand::class);

        return $resolver->resolve($request)->run($request, $responseBuilder);
    }
}