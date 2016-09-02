<?php
namespace CASS\Domain\IM\Middleware;

use CASS\Application\Service\CommandService;
use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Domain\IM\Middleware\Command\MessagesCommand;
use CASS\Domain\IM\Middleware\Command\SendCommand;
use CASS\Domain\IM\Middleware\Command\UnreadCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileIMMiddleware implements MiddlewareInterface
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
            ->attachDirect('send', SendCommand::class)
            ->attachDirect('unread', UnreadCommand::class)
            ->attachDirect('messages', MessagesCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}