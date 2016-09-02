<?php
namespace CASS\Domain\Auth\Middleware\Command\OAuth;

use CASS\Application\Command\Command;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Account\Exception\AccountNotFoundException;
use CASS\Domain\Auth\Service\AuthService;
use CASS\Domain\Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use CASS\Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractCommand implements Command
{
    /** @var array */
    private $oauth2Config;

    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService, array $oauth2Config)
    {
        $this->authService = $authService;
        $this->oauth2Config = $oauth2Config;
    }

    protected function getOauth2Config(): array
    {
        return $this->oauth2Config;
    }

    abstract protected function getOAuth2Provider(): AbstractProvider;
    abstract protected function makeRegistrationRequest(AbstractProvider $provider, AccessToken $accessToken): RegistrationRequest;

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {
        $provider = $this->getOAuth2Provider();

        if(isset($_GET['code'])) {
            // TODO:: fix; $this->preventCSRFAttack();

            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);

            $registrationRequest = $this->makeRegistrationRequest($provider, $accessToken);

            try {
                $account = $this->authService->signInOauth2($registrationRequest);

                $responseBuilder->setStatusSuccess()->setJson([
                    "api_key" => $account->getAPIKey()
                ]);

                header('Location: /');
                exit();
            }catch(AccountNotFoundException $e) {
                $responseBuilder
                    ->setStatusNotFound()
                    ->setError($e);
            }catch(InvalidCredentialsException $e) {
                $responseBuilder
                    ->setStatusNotFound()
                    ->setError($e);
            }
        }else{
            $this->moveToAuth($provider);
        }

        return $responseBuilder->build();
    }


    private function moveToAuth(AbstractProvider $provider)
    {
        $authorizationUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();
        header('Location: ' . $authorizationUrl);
        exit;
    }
}