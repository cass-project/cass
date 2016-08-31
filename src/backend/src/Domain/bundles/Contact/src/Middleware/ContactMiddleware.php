<?php
namespace Domain\Contact\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use Domain\Contact\Middleware\Command\CreateCommand;
use Domain\Contact\Middleware\Command\DeleteCommand;
use Domain\Contact\Middleware\Command\GetCommand;
use Domain\Contact\Middleware\Command\ListCommand;
use Domain\Contact\Middleware\Command\SetPermanentCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class ContactMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null): Response
    {
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('create', CreateCommand::class)
            ->attachDirect('delete', DeleteCommand::class)
            ->attachDirect('list', ListCommand::class)
            ->attachDirect('get', GetCommand::class)
            ->attachDirect('set-permanent', SetPermanentCommand::class);

        return $resolver
            ->resolve($request)
            ->run($request, $responseBuilder);
    }
}