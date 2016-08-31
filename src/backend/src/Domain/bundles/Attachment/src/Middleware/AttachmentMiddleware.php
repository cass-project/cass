<?php
namespace Domain\Attachment\Middleware;

use CASS\Application\Service\CommandService;
use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use Domain\Attachment\Middleware\Command\LinkCommand;
use Domain\Attachment\Middleware\Command\UploadCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AttachmentMiddleware implements MiddlewareInterface
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
            ->attachDirect('upload', UploadCommand::class)
            ->attachDirect('link', LinkCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}