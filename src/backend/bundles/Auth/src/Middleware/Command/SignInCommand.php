<?php
namespace Auth\Middleware\Command;

use Auth\Formatter\SignInFormatter;
use Common\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Account\Exception\AccountNotFoundException;
use Profile\Entity\Profile;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $account = $this->getAuthService()->signIn($request);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson((new SignInFormatter())->format($account))
            ;
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