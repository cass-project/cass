<?php
namespace Domain\Profile\Middleware;

use Application\Service\CommandService;
use Application\REST\Response\GenericResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Middleware\Command\CreateCommand;
use Domain\Profile\Middleware\Command\DeleteCommand;
use Domain\Profile\Middleware\Command\EditPersonalCommand;
use Domain\Profile\Middleware\Command\ExpertInPutCommand;
use Domain\Profile\Middleware\Command\GetCommand;
use Domain\Profile\Middleware\Command\GreetingsAsCommand;
use Domain\Profile\Middleware\Command\ImageDeleteCommand;
use Domain\Profile\Middleware\Command\ImageUploadCommand;
use Domain\Profile\Middleware\Command\InterestingInPutCommand;
use Domain\Profile\Middleware\Command\SetGenderCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = NULL)
    {
        $responseBuilder = new GenericResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect("create", CreateCommand::class)
            ->attachDirect("delete", DeleteCommand::class)
            ->attachDirect("get", GetCommand::class)
            ->attachDirect("greetings-as", GreetingsAsCommand::class)
            ->attachDirect("image-upload", ImageUploadCommand::class)
            ->attachDirect('image-delete', ImageDeleteCommand::class)
            ->attachDirect("edit-personal", EditPersonalCommand::class)
            ->attachDirect("expert-in", ExpertInPutCommand::class, 'put')
            ->attachDirect('interesting-in', InterestingInPutCommand::class, 'put')
            ->attachDirect('set-gender', SetGenderCommand::class)
            ->resolve($request);
        
        try {
            return $resolver->run($request, $responseBuilder);
        }catch(ProfileNotFoundException $e) {
            return $responseBuilder
                ->setStatusNotFound()
                ->build();
        }
    }
}