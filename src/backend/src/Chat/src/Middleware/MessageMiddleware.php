<?php
namespace CASS\Chat\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Chat\Middleware\Command\GetProfileMessagesCommand;
use CASS\Chat\Middleware\Command\ProfileSendProfileMessageCommand;
use CASS\Chat\Middleware\Command\SendProfileMessageCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class MessageMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver =  $this->commandService->createResolverBuilder()
            ->attachDirect('profile-send', SendProfileMessageCommand::class, 'PUT')
            ->attachDirect('profile-send-profile', ProfileSendProfileMessageCommand::class, 'PUT')
            ->attachDirect('get-messages', GetProfileMessagesCommand::class, 'POST')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }

}