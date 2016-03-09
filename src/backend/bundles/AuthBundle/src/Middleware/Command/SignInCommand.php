<?php
namespace Auth\Middleware\Command;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        sleep(1);

        try {
            $account = $this->getAuthService()->signIn($request);
            $responseBuilder->setStatusSuccess()->setJson([
                "api_key"=>$account->getToken()
            ]);
        }catch(InvalidCredentialsException $e) {
            $responseBuilder
                ->setStatusSuccess()
                ->setError($e)
            ;
        }
    }
}