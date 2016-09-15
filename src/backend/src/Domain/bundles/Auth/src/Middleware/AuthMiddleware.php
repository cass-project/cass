<?php
namespace CASS\Domain\Bundles\Auth\Middleware;

use CASS\Application\REST\CASSResponseBuilder;
use CASS\Application\Service\CommandService;
use CASS\Domain\Bundles\Account\Exception\AccountNotFoundException;
use CASS\Domain\Bundles\Auth\Middleware\Command\OAuth\BattleNetCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\OAuth\FacebookCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\OAuth\GoogleCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\OAuth\MailruCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\OAuth\OdnoklassnikiCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\OAuth\VkCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\OAuth\YandexCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\SignInCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\SignOutCommand;
use CASS\Domain\Bundles\Auth\Middleware\Command\SignUpCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /** @var CommandService */
    private $commandService;

    const OAUTH2_PROVIDERS = [
        'google' => GoogleCommand::class,
        'facebook' => FacebookCommand::class,
        'battle.net' => BattleNetCommand::class,
        'mail.ru' => MailruCommand::class,
        'odnoklassniki' => OdnoklassnikiCommand::class,
        'vk' => VkCommand::class,
        'yandex' => YandexCommand::class
    ];

    public function __construct(CommandService $commandService) {
        $this->commandService = $commandService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new CASSResponseBuilder($response);

        $resolver = $this->commandService->createResolverBuilder()
            ->attachDirect('sign-in', SignInCommand::class)
            ->attachDirect('sign-up', SignUpCommand::class)
            ->attachDirect('sign-out', SignOutCommand::class)
        ;

        foreach (self::OAUTH2_PROVIDERS as $provider => $commandClassName) {
            $resolver->attachCallable(function(Request $request) use ($resolver, $provider) {
                return $request->getAttribute('command')  === 'oauth'
                    && $request->getAttribute('provider') === $provider;
            }, $commandClassName);
        }

        try {
            return $resolver
                ->resolve($request)
                ->run($request, $responseBuilder);
        }catch(AccountNotFoundException $e) {
            return $responseBuilder
                ->setStatusNotFound()
                ->build();
        }
    }
}