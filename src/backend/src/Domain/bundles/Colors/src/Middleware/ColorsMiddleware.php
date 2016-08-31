<?php
namespace Domain\Colors\Middleware;

use ZEA2\Platform\Bundles\REST\Response\GenericResponseBuilder;
use CASS\Application\Service\CommandService;
use Domain\Colors\Middleware\Command\GetColorsCommand;
use Domain\Colors\Middleware\Command\GetPalettesCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ColorsMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null) {
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('get-colors', GetColorsCommand::class)
            ->attachDirect('get-palettes', GetPalettesCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}