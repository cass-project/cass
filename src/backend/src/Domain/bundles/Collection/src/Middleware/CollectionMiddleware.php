<?php
namespace Domain\Collection\Middleware;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Middleware\Command\Command;
use Domain\Collection\Service\CollectionService;
use Application\REST\Response\GenericResponseBuilder;
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
        $responseBuilder = new GenericResponseBuilder($response);

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