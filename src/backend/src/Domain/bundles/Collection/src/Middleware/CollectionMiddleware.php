<?php
namespace Domain\Collection\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use Domain\Collection\Exception\CollectionNotFoundException;
use Domain\Collection\Middleware\Command\CreateCommand;
use Domain\Collection\Middleware\Command\DeleteCommand;
use Domain\Collection\Middleware\Command\EditCommand;
use Domain\Collection\Middleware\Command\ImageDeleteCommand;
use Domain\Collection\Middleware\Command\ImageUploadCommand;
use Domain\Collection\Middleware\Command\SetPublicOptionsCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class CollectionMiddleware implements MiddlewareInterface
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

        try {
            $resolver = $this->commandService->createResolverBuilder()
                ->attachDirect('create', CreateCommand::class)
                ->attachDirect('delete', DeleteCommand::class)
                ->attachDirect('edit', EditCommand::class)
                ->attachDirect('image-upload', ImageUploadCommand::class)
                ->attachDirect('image-delete', ImageDeleteCommand::class)
                ->attachDirect('set-public-options', SetPublicOptionsCommand::class)
                ->resolve($request);

            return $resolver->run($request, $responseBuilder);
        }catch(CollectionNotFoundException $e) {
            return $responseBuilder
                ->setError($e)
                ->setStatusNotFound()
                ->build();
        }
    }
}