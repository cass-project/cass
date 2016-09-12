<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware;

use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Subscribe\Middleware\Command\SubscribeThemeCommand;
use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SubscribeMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect("subscribe-theme-subscribe", SubscribeThemeCommand::class)
            ->attachDirect("subscribe-theme-unsubscribe", SubscribeThemeCommand::class)
            ->attachDirect("subscribe-theme-list", SubscribeThemeCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}