<?php
namespace CASS\Chat\Bundles\Contact\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Chat\Bundles\Contact\Middleware\Command\ListContactsCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ContactMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect("list", ListContactsCommand::class, 'GET')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}