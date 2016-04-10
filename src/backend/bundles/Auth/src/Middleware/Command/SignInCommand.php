<?php
namespace Auth\Middleware\Command;

use Common\REST\GenericRESTResponseBuilder;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Data\Exception\Auth\AccountNotFoundException;
use Profile\Entity\Profile;
use Psr\Http\Message\ServerRequestInterface;

class SignInCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $account = $this->getAuthService()->signIn($request);

            $profiles = array_map(function(Profile $profile) {
                return $profile->toJSON();
            }, $account->getProfiles()->toArray());

            $responseBuilder->setStatusSuccess()->setJson([
                "api_key" => $account->getAPIKey(),
                "profiles" => $profiles
            ]);
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