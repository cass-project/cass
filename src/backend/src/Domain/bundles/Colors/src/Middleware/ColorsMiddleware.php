<?php
namespace CASS\Domain\Bundles\Colors\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Colors\Middleware\Command\GetColorsCommand;
use CASS\Domain\Bundles\Colors\Middleware\Command\GetPalettesCommand;
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
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('get-colors', GetColorsCommand::class)
            ->attachDirect('get-palettes', GetPalettesCommand::class)
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}