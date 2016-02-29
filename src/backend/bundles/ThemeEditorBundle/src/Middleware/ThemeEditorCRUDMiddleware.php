<?php
namespace ThemeEditor\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use ThemeEditor\Middleware\Command\Command;
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

        $command = Command::factory($request);
        $command->setThemeEditorService($this->themeEditorService);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson($command->run($request))
            ->build()
        ;
    }
}