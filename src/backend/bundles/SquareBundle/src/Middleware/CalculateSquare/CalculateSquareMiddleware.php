<?php
namespace Square\Middleware\CalculateSquare;

use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Square\Service\Square\SquareService;
use Zend\Stratigility\MiddlewareInterface;
use Square\Service\Square\InvalidInputException;

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
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $input = $request->getAttribute('input');
            $result = $this->squareService->calculate($input);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson(['result' => $result])
            ;
        }catch(InvalidInputException $e) {
            $responseBuilder
                ->setStatusNotAllowed()
                ->setError($e)
            ;
        }

        return $responseBuilder->build();
    }
}