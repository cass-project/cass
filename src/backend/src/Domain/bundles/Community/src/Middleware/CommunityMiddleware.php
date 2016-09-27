<?php
namespace CASS\Domain\Bundles\Community\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Community\Middleware\Command\Backdrop\BackdropColorCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\Backdrop\BackdropNoneCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\Backdrop\BackdropPresetCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\Backdrop\BackdropUploadCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\CreateCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\ImageDeleteCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\EditCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\GetByIdCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\getBySIDCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\ImageUploadCommand;
use CASS\Domain\Bundles\Community\Middleware\Command\SetPublicOptionsCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class CommunityMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('create', CreateCommand::class)
            ->attachDirect('edit', EditCommand::class)
            ->attachDirect('image-upload', ImageUploadCommand::class)
            ->attachDirect('image-delete', ImageDeleteCommand::class)
            ->attachDirect('get', GetByIdCommand::class)
            ->attachDirect('get-by-sid', getBySIDCommand::class)
            ->attachDirect('set-public-options', SetPublicOptionsCommand::class)
            ->attachDirect('backdrop-upload', BackdropUploadCommand::class, 'POST')
            ->attachDirect('backdrop-none', BackdropNoneCommand::class, 'POST')
            ->attachDirect('backdrop-preset', BackdropPresetCommand::class, 'POST')
            ->attachDirect('backdrop-color', BackdropColorCommand::class, 'POST')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}