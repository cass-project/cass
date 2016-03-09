<?php
namespace Auth\Middleware\Command;

use Application\REST\Exceptions\UnknownActionException;
use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\OAuth\FacebookCommand;
use Auth\Middleware\Command\OAuth\GoogleCommand;
use Auth\Middleware\Command\OAuth\MailruCommand;
use Auth\Middleware\Command\OAuth\OdnoklassnikiCommand;
use Auth\Middleware\Command\OAuth\VkCommand;
use Auth\Middleware\Command\OAuth\YandexCommand;
use Auth\Service\AuthService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{
    /**
     * @var AuthService
     */
    private $authService;

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



    abstract public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder);
}