<?php
namespace ThemeEditor\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ThemeEditor\Middleware\Command\Command;
use ThemeEditor\Middleware\Command\CreateThemeCommand;
use ThemeEditor\Middleware\Command\DeleteThemeCommand;
use ThemeEditor\Middleware\Command\ReadThemeCommand;
use ThemeEditor\Middleware\Command\UpdateThemeCommand;
use ThemeEditor\Service\ThemeEditorService;
use Zend\Stratigility\MiddlewareInterface;

class ThemeEditorCRUDMiddleware implements MiddlewareInterface
{
    /**
     * @var ThemeEditorService
     */
    private $themeEditorService;

    public function __construct(ThemeEditorService $themeEditorService)
    {
        $this->themeEditorService = $themeEditorService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $command = $this->commandFactory($request);
        $result = $command->run();

        $responseBuilder = new GenericRESTResponseBuilder($response);
        $responseBuilder
            ->setStatusSuccess()
            ->setJson($result)
        ;

        return $responseBuilder->build();
    }

    /**
     * @param Request $request
     * @return Command
     * @throws \Exception
     */
    private function commandFactory(Request $request)
    {
        $command = $request->getAttribute('command');

        switch ($command) {
            default:
                throw new \Exception(sprintf('Command `%s` not found', $command));

            case 'read':
                return new ReadThemeCommand($request);

            case 'create':
                return new CreateThemeCommand($request);

            case 'update':
                return new UpdateThemeCommand($request);

            case 'delete':
                return new DeleteThemeCommand($request);
        }
    }
}