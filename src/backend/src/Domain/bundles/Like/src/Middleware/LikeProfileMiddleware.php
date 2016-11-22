<?php

namespace CASS\Domain\Bundles\Like\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand\AddDislikeProfileCommand;
use CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand\AddLikeProfileCommand;
use CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand\RemoveProfileAttitude;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class LikeProfileMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {

        $responseBuilder = new CASSResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('add-like', AddLikeProfileCommand::class, 'PUT')
            ->attachDirect('add-dislike', AddDislikeProfileCommand::class, 'PUT')
            ->attachDirect('remove-attitude', RemoveProfileAttitude::class, 'DELETE')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }

}