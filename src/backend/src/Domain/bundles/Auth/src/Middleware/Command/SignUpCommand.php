<?php
namespace CASS\Domain\Auth\Middleware\Command;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Application\Bundles\Frontline\Service\FrontlineService\IncludeFilter;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Auth\Formatter\SignInFormatter;
use CASS\Domain\Auth\Middleware\Request\SignUpRequest;
use CASS\Domain\Auth\Exception\DuplicateAccountException;
use CASS\Domain\Auth\Exception\MissingRequiredFieldException;
use CASS\Domain\Auth\Exception\ValidationException;
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