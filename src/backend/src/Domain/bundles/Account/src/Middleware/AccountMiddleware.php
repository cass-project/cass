<?php
namespace Domain\Account\Middleware;

use Application\REST\Response\GenericResponseBuilder;
use Application\Service\CommandService;
use Domain\Account\Exception\AccountNotFoundException;
use Domain\Account\Middleware\Command\CancelDeleteRequestCommand;
use Domain\Account\Middleware\Command\DeleteRequestCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AccountMiddleware implements MiddlewareInterface
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

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('request-delete', DeleteRequestCommand::class)
            ->attachDirect('cancel-request-delete', CancelDeleteRequestCommand::class)
            ->resolve($request);
        try {
            return $resolver->run($request, $responseBuilder);
        }catch(AccountNotFoundException $e) {
            return $responseBuilder->setStatusNotFound()
                ->build();
        }
    }
}