<?php
namespace Auth\Middleware\Command;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $account = $this->getAuthService()->signIn($request);
            $responseBuilder->setStatusSuccess()->setJson([
                    "account_token"=>$account->getToken()
            ]);
        }catch(InvalidCredentialsException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }
    }
}