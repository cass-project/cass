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

            $responseBuilder->setStatusSuccess()->setJson([
                "api_key" => $account->getAPIKey()
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