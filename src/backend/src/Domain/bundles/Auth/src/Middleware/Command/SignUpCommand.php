<?php
namespace Domain\Auth\Middleware\Command;

use Domain\Auth\Formatter\SignInFormatter;
use Application\REST\Response\GenericResponseBuilder;
use Domain\Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Domain\Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;
use Domain\Auth\Service\AuthService\Exceptions\ValidationException;
use Psr\Http\Message\ServerRequestInterface;

class SignUpCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericResponseBuilder $responseBuilder)
    {
        try {
            $account = $this->getAuthService()->signUp($request);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson((new SignInFormatter())->format($account))
            ;
        }catch(MissingReqiuredFieldException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }catch(DuplicateAccountException $e) {
            $responseBuilder
                ->setStatusNotFound()
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