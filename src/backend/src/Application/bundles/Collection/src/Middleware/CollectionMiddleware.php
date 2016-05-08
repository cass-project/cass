<?php
namespace Application\Collection\Middleware;

use Application\Auth\Service\CurrentAccountService;
use Application\Collection\Middleware\Command\Command;
use Application\Collection\Service\CollectionService;
use Application\Common\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class CollectionMiddleware implements MiddlewareInterface
{
    /** @var CollectionService */
    private $collectionService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CollectionService $collectionService, CurrentAccountService $currentAccountService)
    {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        $command = Command::factory($request, $this->collectionService);
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