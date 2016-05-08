<?php
namespace Domain\Theme\Middleware;

use Domain\Auth\Service\CurrentAccountService;
use Application\REST\Response\GenericResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Domain\Theme\Middleware\Command\Command;
use Domain\Theme\Service\ThemeService;
use Zend\Stratigility\MiddlewareInterface;

class ThemeMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ThemeService */
    private $themeService;

    public function __construct(CurrentAccountService $currentAccountService, ThemeService $themeService)
    {
        $this->currentAccountService = $currentAccountService;
        $this->themeService = $themeService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        $command = Command::factory($request, $this->currentAccountService, $this->themeService);
        $result = $command->run($request);

        if($result === true) {
            $result = [];
        }

        $responseBuilder
            ->setStatusSuccess()
            ->setJson($result);

        return $responseBuilder->build();
    }
}