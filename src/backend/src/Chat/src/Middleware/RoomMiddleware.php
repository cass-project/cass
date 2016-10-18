<?php

namespace CASS\Chat\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Chat\Middleware\Command\CreateRoomCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use CASS\Application\Service\CommandService;
use Zend\Stratigility\MiddlewareInterface;

class RoomMiddleware implements MiddlewareInterface
{
    /** @var CommandService  */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver =  $this->commandService->createResolverBuilder()
            ->attachDirect('room-create', CreateRoomCommand::class, 'PUT')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}