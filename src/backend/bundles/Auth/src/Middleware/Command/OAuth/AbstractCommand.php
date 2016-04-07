<?php
namespace Auth\Middleware\Command\OAuth;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Auth\Service\AuthService;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Data\Exception\Auth\AccountNotFoundException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractCommand extends Command
{
    /** @var array */
    private $oauth2Config;

    /** @var AuthService */
    private $authService;

    public function __construct(array $oauth2Config, AuthService $authService)
    {
        $this->oauth2Config = $oauth2Config;
        $this->authService = $authService;
    }

    protected function getOauth2Config(): array
    {
        return $this->oauth2Config;
    }

    abstract protected function getOAuth2Provider(): AbstractProvider;
    abstract protected function makeRegistrationRequest(AbstractProvider $provider, AccessToken $accessToken): RegistrationRequest;

    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        $provider = $this->getOAuth2Provider();

        if(isset($_GET['code'])) {
            // TODO:: fix; $this->preventCSRFAttack();

            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);


            $registrationRequest = $this->makeRegistrationRequest($provider, $accessToken);

            try {
                $account = $this->getAuthService()->signInOauth2($registrationRequest);

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
    }

    private function moveToAuth(AbstractProvider $provider)
    {
        $authorizationUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();
        header('Location: ' . $authorizationUrl);
        exit;
    }

    private function preventCSRFAttack()
    {
        $hasState = !empty($_GET['state']);
        $isSameClient = !empty($_GET['state']) && ($_GET['state'] === $_SESSION['oauth2state']);

        if (!($hasState && $isSameClient)) {
            throw new \Exception('Invalid state. Looks like a CSRF attack so gtfo.');
        }
    }
}