<?php
namespace CASS\Domain\Bundles\Collection\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Collection\Middleware\Command\CreateCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\DeleteCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\EditCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\ImageDeleteCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\ImageUploadCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\SetPublicOptionsCommand;
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