<?php
namespace Domain\ProfileIM\Middleware;

use Application\Service\CommandService;
use Domain\Auth\Service\CurrentAccountService;
use Application\REST\Response\GenericResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\ProfileIM\Exception\SameTargetAndSourceException;
use Domain\ProfileIM\Middleware\Command\Command;
use Domain\Profile\Service\ProfileService;
use Domain\ProfileIM\Middleware\Command\MessagesCommand;
use Domain\ProfileIM\Middleware\Command\SendCommand;
use Domain\ProfileIM\Middleware\Command\UnreadCommand;
use Domain\ProfileIM\Service\ProfileIMService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileIMMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService)
    {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        try {
            $resolver = $this->commandService->createResolverBuilder()
                ->attachDirect('send', SendCommand::class)
                ->attachDirect('unread', UnreadCommand::class)
                ->attachDirect('messages', MessagesCommand::class)
                ->resolve($request);

            return $resolver->run($request, $responseBuilder);
        } catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        } catch(SameTargetAndSourceException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e);
        }
        
        return $responseBuilder->build();
    }
}