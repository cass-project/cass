<?php
namespace Domain\Auth\Middleware\Command;

use Application\REST\Response\GenericResponseBuilder;
use Domain\Auth\Middleware\Command\OAuth\BattleNetCommand;
use Domain\Auth\Middleware\Command\OAuth\FacebookCommand;
use Domain\Auth\Middleware\Command\OAuth\GoogleCommand;
use Domain\Auth\Middleware\Command\OAuth\MailruCommand;
use Domain\Auth\Middleware\Command\OAuth\OdnoklassnikiCommand;
use Domain\Auth\Middleware\Command\OAuth\VkCommand;
use Domain\Auth\Middleware\Command\OAuth\YandexCommand;
use Domain\Auth\Service\AuthService;
use Application\Frontline\Service\FrontlineService;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Console\Exception\CommandNotFoundException;

abstract class Command
{
    /** @var AuthService */
    protected $authService;

    /** @var FrontlineService */
    protected $frontlineService;

    public static function factory(ServerRequestInterface $request, AuthService $authService): Command {
        $method = $request->getAttribute('action');

        switch($method) {
            default:
                throw new CommandNotFoundException(sprintf('Unknown action `%s`', $method));

            case 'sign-in': return new SignInCommand();
            case 'sign-up': return new SignUpCommand();
            case 'sign-out': return new SignOutCommand();
            case 'oauth':
                switch($request->getAttribute('provider')){
                    default: throw new \Exception('Unknown provider');
                    case 'vk': return new VkCommand($authService->getOAuth2Config('vk'), $authService);
                    case 'mailru': return new MailruCommand($authService->getOAuth2Config('mailru'), $authService);
                    case 'yandex': return new YandexCommand($authService->getOAuth2Config('yandex'), $authService);
                    case 'google': return new GoogleCommand($authService->getOAuth2Config('google'), $authService);
                    case 'facebook': return new FacebookCommand($authService->getOAuth2Config('facebook'), $authService);
                    case 'odnoklassniki': return new OdnoklassnikiCommand($authService->getOAuth2Config('odnoklassniki'), $authService);
                    case 'battle.net': return new BattleNetCommand($authService->getOAuth2Config('battle.net'), $authService);
                }
        }
    }

    protected function getAuthService(): AuthService
    {
        if($this->authService === null) {
            throw new \Exception('No AuthService available');
        }

        return $this->authService;
    }

    public function setAuthService(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function setFrontlineService(FrontlineService $frontlineService) 
    {
        $this->frontlineService = $frontlineService;
    }

    protected function getFrontlineService(): FrontlineService
    {
        return $this->frontlineService;
    }

    abstract public function run(ServerRequestInterface $request, GenericResponseBuilder $responseBuilder);
}