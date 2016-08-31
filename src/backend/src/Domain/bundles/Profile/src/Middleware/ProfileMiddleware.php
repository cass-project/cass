<?php
namespace Domain\Profile\Middleware;

use CASS\Application\Service\CommandService;
use CASS\Application\REST\Response\GenericResponseBuilder;
use Domain\Profile\Middleware\Command\CreateCommand;
use Domain\Profile\Middleware\Command\DeleteCommand;
use Domain\Profile\Middleware\Command\EditPersonalCommand;
use Domain\Profile\Middleware\Command\ExpertInPutCommand;
use Domain\Profile\Middleware\Command\GetBySIDCommand;
use Domain\Profile\Middleware\Command\GetCommand;
use Domain\Profile\Middleware\Command\GreetingsAsCommand;
use Domain\Profile\Middleware\Command\ImageDeleteCommand;
use Domain\Profile\Middleware\Command\ImageUploadCommand;
use Domain\Profile\Middleware\Command\InterestingInPutCommand;
use Domain\Profile\Middleware\Command\SetBirthdayCommand;
use Domain\Profile\Middleware\Command\SetGenderCommand;
use Domain\Profile\Middleware\Command\UnsetBirthdayCommand;
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
            ->attachDirect('by-sid', GetBySIDCommand::class)
            ->attachDirect("greetings-as", GreetingsAsCommand::class)
            ->attachDirect("image-upload", ImageUploadCommand::class)
            ->attachDirect('image-delete', ImageDeleteCommand::class)
            ->attachDirect("edit-personal", EditPersonalCommand::class)
            ->attachDirect("expert-in", ExpertInPutCommand::class, 'PUT')
            ->attachDirect('interesting-in', InterestingInPutCommand::class, 'PUT')
            ->attachDirect('set-gender', SetGenderCommand::class)
            ->attachDirect('birthday', SetBirthdayCommand::class, 'POST')
            ->attachDirect('birthday', UnsetBirthdayCommand::class, 'DELETE')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}