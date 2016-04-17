<?php
namespace Auth\Middleware\Command;

use Common\REST\Exceptions\UnknownActionException;
use Common\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\OAuth\BattleNetCommand;
use Auth\Middleware\Command\OAuth\FacebookCommand;
use Auth\Middleware\Command\OAuth\GoogleCommand;
use Auth\Middleware\Command\OAuth\MailruCommand;
use Auth\Middleware\Command\OAuth\OdnoklassnikiCommand;
use Auth\Middleware\Command\OAuth\VkCommand;
use Auth\Middleware\Command\OAuth\YandexCommand;
use Auth\Service\AuthService;
use Frontline\Service\FrontlineService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    /** @var AuthService */
    protected $authService;

    /** @var FrontlineService */
    protected $frontlineService;

    public static function factory(ServerRequestInterface $request, AuthService $authService): Command {
        $action = $request->getAttribute('action');

        switch($action) {
            default:
                throw new UnknownActionException(sprintf('Unknown action `%s`', $action));

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

    public function getAuthService(): AuthService
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

    abstract public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder);
}