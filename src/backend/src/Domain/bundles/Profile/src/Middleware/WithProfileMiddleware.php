<?php
namespace Domain\Profile\Middleware;

use Application\REST\Response\GenericResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Service\WithProfileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class WithProfileMiddleware implements MiddlewareInterface
{
    /** @var WithProfileService */
    private $withProfileService;

    public function __construct(WithProfileMiddleware $withProfileService)
    {
        $this->withProfileService = $withProfileService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        try {
            $this->withProfileService->specifyProfile((int) $request->getAttribute('profileId'));

            return $out($request, $response);
        }catch(ProfileNotFoundException $e){
            $responseBuilder = new GenericResponseBuilder($response);

            return $responseBuilder
                ->setStatusNotAllowed()
                ->setError($e)
                ->build();
        }
    }
}