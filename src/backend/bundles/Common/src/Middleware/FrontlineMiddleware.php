<?php
namespace Common\Middleware;

use Common\Service\FrontlineService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class FrontlineMiddleware implements MiddlewareInterface
{
    /** @var FrontlineService */
    private $frontlineService;

    public function __construct(FrontlineService $frontlineService)
    {
        $this->frontlineService = $frontlineService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        return $this->frontlineService->importToJSON();
    }
}