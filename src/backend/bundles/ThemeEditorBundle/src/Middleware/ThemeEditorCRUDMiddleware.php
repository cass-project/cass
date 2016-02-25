<?php
namespace ThemeEditor\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Application\REST\InvalidRESTRequestException;

use Data\Exception\DataEntityNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ThemeEditor\Middleware\Command\Command;
use ThemeEditor\Middleware\Command\CreateThemeCommand;
use ThemeEditor\Middleware\Command\DeleteThemeCommand;
use ThemeEditor\Middleware\Command\MoveThemeCommand;
use ThemeEditor\Middleware\Command\ReadThemeCommand;
use ThemeEditor\Middleware\Command\UpdateThemeCommand;
use ThemeEditor\Middleware\Exception\CommandException;
use ThemeEditor\Service\ThemeEditorService;
use Zend\Stratigility\MiddlewareInterface;

class ThemeEditorCRUDMiddleware implements MiddlewareInterface
{
    /** @var ThemeEditorService */
    private $themeEditorService;

    public function __construct(ThemeEditorService $themeEditorService)
    {
        $this->themeEditorService = $themeEditorService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $command = $this->commandFactory($request);
            $command->setThemeEditorService($this->themeEditorService);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($command->run($request))
            ;
        }catch(CommandException $e){
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        }catch(DataEntityNotFoundException $e){
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }catch(InvalidRESTRequestException $e){
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        }

        return $responseBuilder
            ->build()
        ;
    }

    private function commandFactory(Request $request): Command
    {
        $command = $request->getAttribute('command');

        switch ($command) {
            default:
                throw new \Exception(sprintf('Command `%s` not found', $command));

            case 'read':
                return new ReadThemeCommand();

            case 'create':
                return new CreateThemeCommand();

            case 'update':
                return new UpdateThemeCommand();

            case 'delete':
                return new DeleteThemeCommand();

            case 'move':
                return new MoveThemeCommand();
        }
    }
}