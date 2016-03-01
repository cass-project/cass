<?php
namespace Auth\Middleware\Command;

use Application\REST\Exceptions\UnknownActionException;
use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\OAuth\VkCommand;
use Auth\Service\AuthService;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command
{

    /**
     * @var AuthService
     */
    private $authService;

    public static function factory(ServerRequestInterface $request) : Command
    {
        $action = $request->getAttribute('action');

        switch ($action) {
            case 'sign-in': return new SignInCommand();
            case 'sign-up': return new SignUpCommand();
            case 'sign-out': return new SignOutCommand();
            case 'oauth':
                switch ($request->getAttribute('provider')) {
                    case 'vk': return new VkCommand();
                    case 'mailru': return new VkCommand();
                    case 'yandex': return new VkCommand();
                    case 'google': return new VkCommand();
                    case 'facebook': return new VkCommand();
                    case 'odnoklassniki': return new VkCommand();
                }
        }

        throw new UnknownActionException('Unknown action');
    }

    public function getAuthService(): AuthService
    {
        if ($this->authService === null) {
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