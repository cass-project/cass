<?php
namespace CASS\Application\Bundles\Frontline\Middleware;

use CASS\Application\Bundles\Frontline\Service\FrontlineService;
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
        $tags = explode(',', urldecode($request->getAttribute('tags')));

        if(in_array('*', $tags)) {
            $filter = new FrontlineService\NoneFilter();
        }else{
            $filter = new FrontlineService\IncludeFilter();
            $filter->includeTags($tags);
        }

        $response->getBody()->write(json_encode([
                'success' => true
            ] + $this->frontlineService->fetch($filter), JSON_UNESCAPED_SLASHES));

        return $response
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
        ;
    }
}