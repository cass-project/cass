<?php
namespace CASS\Domain\Bundles\Contact\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Contact\Middleware\Command\CreateCommand;
use CASS\Domain\Bundles\Contact\Middleware\Command\DeleteCommand;
use CASS\Domain\Bundles\Contact\Middleware\Command\GetCommand;
use CASS\Domain\Bundles\Contact\Middleware\Command\ListCommand;
use CASS\Domain\Bundles\Contact\Middleware\Command\SetPermanentCommand;
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