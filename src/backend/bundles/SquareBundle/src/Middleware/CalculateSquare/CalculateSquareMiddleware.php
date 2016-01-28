<?php
namespace Square\Middleware\CalculateSquare;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Square\Service\Square\SquareService;
use Zend\Stratigility\MiddlewareInterface;

class CalculateSquareMiddleware implements MiddlewareInterface
{
    /**
     * @var SquareService
     */
    private $squareService;

    public function __construct(SquareService $squareService)
    {
        $this->squareService = $squareService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $input = $request->getAttribute('input');

        $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode([
            'success' => true,
            'result' => $this->squareService->calculate($input)
        ]));

        return $response;
    }
}