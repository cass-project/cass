<?php
namespace Auth\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Application\REST\Exceptions\UnknownActionException;
use Auth\OauthProvider\Mailru;
use Auth\OauthProvider\Vk;
use Auth\Service\AuthService;
use Auth\Service\AuthService\Exceptions\InvalidCredentialsException;
use Doctrine\ORM\NoResultException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * AuthMiddleware constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        try {
            $action = $request->getAttribute('action');

            switch($action) {
                default:
                    throw new UnknownActionException(sprintf('Unknown action `%s`', $action));

                case 'sign-in':
                    $this->signIn($request, $responseBuilder);
                    break;

                case 'sign-up':
                    $this->signUp($request, $responseBuilder);
                    break;

                case 'logout':
                    $this->logOut($request, $responseBuilder);
                    break;

                case 'oauth':
                    switch($request->getAttribute('provider')){
                        case 'vk':
                            $this->oauthVk($request, $responseBuilder);
                        break;
                        case 'mailru':
                            $this->oauthMailru($request, $responseBuilder);
                        break;
                        case 'yandex':
                            $this->oauthVk($request, $responseBuilder);
                        break;
                        case 'google':
                            $this->oauthVk($request, $responseBuilder);
                        break;
                        case 'facebook':
                            $this->oauthVk($request, $responseBuilder);
                        break;
                        case 'odnoklassniki':
                            $this->oauthVk($request, $responseBuilder);
                        break;
                    }
                break;


            }
        }catch (UnknownActionException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e)
            ;
        }

        return $responseBuilder->build();
    }

    private function signIn(Request $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $this->authService->attemptSignIn($request->getQueryParams());
            $responseBuilder->setStatusSuccess();
        }catch(\Exception $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }
    }

    private function signUp(Request $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try {
            $this->authService->signUp($request->getQueryParams());
            $responseBuilder->setStatusSuccess();
        }catch(InvalidCredentialsException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
            ;
        }
    }

    private function logOut(Request $request, GenericRESTResponseBuilder $responseBuilder)
    {

    }


    /**
     * Аторизация вконтакте
     *
     * @param Request                    $request
     * @param GenericRESTResponseBuilder $responseBuilder
     */
    private function oauthVk(Request $request, GenericRESTResponseBuilder $responseBuilder){
        try{
            $provider = new Vk(
              [
                'clientId'     => '5289954',
                'clientSecret' => 'BXjBPK8sdfYoFcYPUArK',
                'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/vk',
                'v'            => 5.45,
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
        } catch(UnknownActionException $e){
            $responseBuilder
              ->setStatusBadRequest()
              ->setError($e);
        }
    }

    /**
     * Авторизация через Mail.ru
     * @param Request                    $request
     * @param GenericRESTResponseBuilder $responseBuilder
     */
    private function oauthMailru(Request $request, GenericRESTResponseBuilder $responseBuilder){
        try{
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
        } catch(UnknownActionException $e){
            $responseBuilder
              ->setStatusBadRequest()
              ->setError($e);
        }
    }
}