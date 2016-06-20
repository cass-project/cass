<?php
namespace Domain\PostAttachment\Middleware;

use Application\Service\CommandService;
use Application\REST\Response\GenericResponseBuilder;
use Domain\PostAttachment\Middleware\Command\UploadCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostAttachmentMiddleware implements MiddlewareInterface
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
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}