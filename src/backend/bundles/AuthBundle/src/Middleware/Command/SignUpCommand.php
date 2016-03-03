<?php
namespace Auth\Middleware\Command;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;
use Auth\Service\AuthService\Exceptions\ValidationException;
use Psr\Http\Message\ServerRequestInterface;

class SignUpCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $this->getAuthService()->signUp($request);
            $responseBuilder->setStatusSuccess();
        } catch (MissingReqiuredFieldException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        } catch (DuplicateAccountException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        } catch (ValidationException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }
    }
}