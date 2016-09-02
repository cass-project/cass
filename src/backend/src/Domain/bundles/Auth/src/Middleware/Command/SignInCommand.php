<?php
namespace CASS\Domain\Bundles\Auth\Middleware\Command;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Application\Bundles\Frontline\Service\FrontlineService\IncludeFilter;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

use CASS\Domain\Bundles\Auth\Middleware\Request\SignInRequest;
use CASS\Domain\Bundles\Auth\Exception\InvalidCredentialsException;
use CASS\Domain\Bundles\Account\Exception\AccountNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        try {
            $request = new SignInRequest($request);
            $account = $this->authService->signIn($request->getParameters());
            $frontline = $this->frontlineService->fetch(new IncludeFilter([
                FrontlineScript::TAG_IS_AUTHENTICATED
            ]));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($this->signInFormatter->format($account, $frontline))
            ;
        }catch(AccountNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }catch(InvalidCredentialsException $e) {
            $responseBuilder
                ->setStatusNotAllowed()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}