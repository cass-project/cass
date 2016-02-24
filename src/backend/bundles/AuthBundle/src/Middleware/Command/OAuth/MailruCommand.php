<?php
namespace Auth\Middleware\Command\OAuth;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Auth\OauthProvider\Mailru;
use Psr\Http\Message\ServerRequestInterface;

class MailruCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {
        $provider = new Mailru(
          [
            'clientId'     => '741989',
            //                'private_key'=>'105c83cafdef7aa90eaf8077c25d97a3',
            'clientSecret' => '624101a79a67e6918ea420338de3002f',
            'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/mailru',
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