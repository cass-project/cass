<?php
namespace Auth\Middleware\Command\OAuth;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Psr\Http\Message\ServerRequestInterface;

class YandexCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        $provider = new Yandex(
          [
            'clientId'     => '37ba46dfecd8464f8298612ecb5641ff',
            'clientSecret' => '20177d8b3379445ead1e262a3ffa76ee',
            'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/yandex',
          ]
        );

        if(!isset($_GET['code'])){
            $authorizationUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authorizationUrl);
            exit;
        }
        elseif(empty($_GET['state']) ||
               ($_GET['state'] !== $_SESSION['oauth2state'])
        ){
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        }
        else{
            try{
                $accessToken = $provider->getAccessToken('authorization_code', [
                                                                               'code' => $_GET['code']
                                                                             ]
                );


                $responseBuilder->setStatusSuccess()
                                ->setJson([$accessToken]);

            } catch(\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e){
                exit($e->getMessage());
            }
        }
    }
}