<?php
namespace Auth\Middleware\Command\OAuth;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Auth\OauthProvider\Vk;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Zend\Diactoros\ServerRequestFactory;

class VkCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {

        $provider = new Vk(
            [
                'clientId'     => '5289954',
                'clientSecret' => 'BXjBPK8sdfYoFcYPUArK',
                'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/vk',
                'v'            => 5.45,
            ]
        );

        if(!isset($_GET['code'])){
            $authorizationUrl = $provider->getAuthorizationUrl(['scope'=>'email']);
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
                    ->setJson([$accessToken,'user_id'=>$provider->user_id,'email'=> $provider->user_email]);

            } catch(\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e){
                exit($e->getMessage());
            }
        }


    }
}