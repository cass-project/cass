<?php
namespace Domain\Auth\Middleware\Command;

use Application\Frontline\FrontlineScript;
use Application\Frontline\Service\FrontlineService\IncludeFilter;
use Domain\Auth\Formatter\SignInFormatter;
use Application\REST\Response\GenericResponseBuilder;
use Domain\Auth\Middleware\Request\SignUpRequest;
use Domain\Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Domain\Auth\Service\AuthService\Exceptions\MissingRequiredFieldException;
use Domain\Auth\Service\AuthService\Exceptions\ValidationException;
use Psr\Http\Message\ServerRequestInterface;

class SignUpCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericResponseBuilder $responseBuilder)
    {
        try {
            $request = new SignUpRequest($request);
            $account = $this->getAuthService()->signUp($request->getParameters());
            $frontline = $this->getFrontlineService()->fetch(new IncludeFilter([
                FrontlineScript::TAG_IS_AUTHENTICATED
            ]));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson((new SignInFormatter())->format($account, $frontline))
            ;
        }catch(MissingRequiredFieldException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }catch(DuplicateAccountException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e)
            ;
        }catch(ValidationException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        }
    }
}