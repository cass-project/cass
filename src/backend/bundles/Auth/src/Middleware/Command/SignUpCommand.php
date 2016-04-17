<?php
namespace Auth\Middleware\Command;

use Auth\Formatter\SignInFormatter;
use Common\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;
use Auth\Service\AuthService\Exceptions\ValidationException;
use Psr\Http\Message\ServerRequestInterface;

class SignUpCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
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