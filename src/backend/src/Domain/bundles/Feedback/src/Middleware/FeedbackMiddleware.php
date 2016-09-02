<?php
namespace CASS\Domain\Feedback\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Feedback\Middleware\Command\CreateCommand;
use CASS\Domain\Feedback\Middleware\Command\CreateFeedbackResponseCommand;
use CASS\Domain\Feedback\Middleware\Command\DeleteCommand;
use CASS\Domain\Feedback\Middleware\Command\GetCommand;
use CASS\Domain\Feedback\Middleware\Command\ListCommand;
use CASS\Domain\Feedback\Middleware\Command\MarkAsReadCommand;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class FeedbackMiddleware implements MiddlewareInterface
{
    /** @var CommandService $commandService */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect("create", CreateCommand::class)
            ->attachDirect("feedback-response", CreateFeedbackResponseCommand::class)
            ->attachDirect("cancel", DeleteCommand::class)
            ->attachDirect("mark-as-read", MarkAsReadCommand::class)
            ->attachDirect("get", GetCommand::class)
            ->attachDirect("list", ListCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}