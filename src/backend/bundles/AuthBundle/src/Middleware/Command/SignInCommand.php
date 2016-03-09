<?php
namespace Auth\Middleware\Command;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Data\Exception\Auth\AccountNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $account = $this->getAuthService()->signIn($request);

            setcookie('api_key', $account->getAPIKey(), time() + 60 /* sec */ * 60 /* min */ * 24 /* hours */ * 30 /* days */, '/');

            $responseBuilder->setStatusSuccess()->setJson([
                "api_key" => $account->getToken()
            ]);
        }catch(AccountNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }catch(InvalidCredentialsException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }
    }
}