<?php
namespace Domain\Auth\Middleware\Command;

use Application\Frontline\FrontlineScript;
use Application\Frontline\Service\FrontlineService\IncludeFilter;
use Domain\Auth\Formatter\SignInFormatter;
use Application\REST\Response\GenericResponseBuilder;
use Domain\Auth\Middleware\Request\SignInRequest;
use Domain\Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Domain\Account\Exception\AccountNotFoundException;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericResponseBuilder $responseBuilder)
    {
        try {
            $request = new SignInRequest($request);
            $account = $this->getAuthService()->signIn($request->getParameters());
            $frontline = $this->getFrontlineService()->fetch(new IncludeFilter([
                FrontlineScript::TAG_IS_AUTHENTICATED
            ]));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson((new SignInFormatter())->format($account, $frontline))
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