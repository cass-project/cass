<?php
namespace Domain\Auth\Middleware\Command;

use Application\Frontline\FrontlineScript;
use Application\Frontline\Service\FrontlineService\IncludeFilter;
use Application\REST\Response\ResponseBuilder;
use Domain\Auth\Formatter\SignInFormatter;
use Domain\Auth\Middleware\Request\SignUpRequest;
use Domain\Auth\Exception\DuplicateAccountException;
use Domain\Auth\Exception\MissingRequiredFieldException;
use Domain\Auth\Exception\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SignUpCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        try {
            $request = new SignUpRequest($request);
            $account = $this->authService->signUp($request->getParameters());
            $frontline = $this->frontlineService->fetch(new IncludeFilter([
                FrontlineScript::TAG_IS_AUTHENTICATED
            ]));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($this->signInFormatter->format($account, $frontline))
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

        return $responseBuilder->build();
    }
}