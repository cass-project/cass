<?php
namespace Application\Auth\Middleware\Command;

use Application\Auth\Formatter\SignInFormatter;
use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Application\Account\Exception\AccountNotFoundException;
use Application\Profile\Entity\Profile;
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