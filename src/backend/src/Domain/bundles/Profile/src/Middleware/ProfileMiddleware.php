<?php
namespace CASS\Domain\Bundles\Profile\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop\BackdropColorCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop\BackdropNoneCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop\BackdropPresetCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\Backdrop\BackdropUploadCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\CreateCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\DeleteCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\EditPersonalCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\ExpertInPutCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\GetBySIDCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\GetCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\GreetingsAsCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\ImageDeleteCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\ImageUploadCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\InterestingInPutCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\SetBirthdayCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\SetGenderCommand;
use CASS\Domain\Bundles\Profile\Middleware\Command\UnsetBirthdayCommand;
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
        $responseBuilder = new CASSResponseBuilder($response);

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
            ->attachDirect('backdrop-upload', BackdropUploadCommand::class, 'POST')
            ->attachDirect('backdrop-none', BackdropNoneCommand::class, 'POST')
            ->attachDirect('backdrop-preset', BackdropPresetCommand::class, 'POST')
            ->attachDirect('backdrop-color', BackdropColorCommand::class, 'POST')
            ->resolve($request);

        return $resolver->run($request, $responseBuilder);
    }
}