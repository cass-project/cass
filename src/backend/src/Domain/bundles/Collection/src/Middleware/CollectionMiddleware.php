<?php
namespace CASS\Domain\Bundles\Collection\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop\BackdropColorCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop\BackdropNoneCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop\BackdropPresetCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\Backdrop\BackdropUploadCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\CreateCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\DeleteCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\EditCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\GetByIdCommand;
use CASS\Domain\Bundles\Collection\Middleware\Command\GetBySIDCommand;
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
        $responseBuilder = new CASSResponseBuilder($response);

        try {
            $resolver = $this->commandService->createResolverBuilder()
                ->attachDirect('by-id', GetByIdCommand::class)
                ->attachDirect('by-sid', GetBySIDCommand::class)
                ->attachDirect('create', CreateCommand::class)
                ->attachDirect('delete', DeleteCommand::class)
                ->attachDirect('edit', EditCommand::class)
                ->attachDirect('image-upload', ImageUploadCommand::class)
                ->attachDirect('image-delete', ImageDeleteCommand::class)
                ->attachDirect('set-public-options', SetPublicOptionsCommand::class)
                ->attachDirect('backdrop-upload', BackdropUploadCommand::class, 'POST')
                ->attachDirect('backdrop-none', BackdropNoneCommand::class, 'POST')
                ->attachDirect('backdrop-preset', BackdropPresetCommand::class, 'POST')
                ->attachDirect('backdrop-color', BackdropColorCommand::class, 'POST')
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