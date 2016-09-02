<?php
namespace CASS\Domain\Community\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Community\Middleware\Command\CreateCommand;
use CASS\Domain\Community\Middleware\Command\ImageDeleteCommand;
use CASS\Domain\Community\Middleware\Command\EditCommand;
use CASS\Domain\Community\Middleware\Command\GetByIdCommand;
use CASS\Domain\Community\Middleware\Command\getBySIDCommand;
use CASS\Domain\Community\Middleware\Command\ImageUploadCommand;
use CASS\Domain\Community\Middleware\Command\SetPublicOptionsCommand;
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
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('create', CreateCommand::class)
            ->attachDirect('edit', EditCommand::class)
            ->attachDirect('image-upload', ImageUploadCommand::class)
            ->attachDirect('image-delete', ImageDeleteCommand::class)
            ->attachDirect('get', GetByIdCommand::class)
            ->attachDirect('get-by-sid', getBySIDCommand::class)
            ->attachDirect('set-public-options', SetPublicOptionsCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}