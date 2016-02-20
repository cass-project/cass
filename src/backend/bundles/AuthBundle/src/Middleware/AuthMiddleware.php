<?php
namespace Auth\Middleware;

use Application\REST\GenericRESTResponseBuilder;
use Application\REST\Exceptions\UnknownActionException;
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

//                            die("test");
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

    private function oauth(Request $request, GenericRESTResponseBuilder $responseBuilder)
    {
        try{

            $provider = new \League\OAuth2\Client\Provider\GenericProvider(
              [
                'clientId'                => 'demoapp',
                // The client ID assigned to you by the provider
                'clientSecret'            => 'demopass',
                // The client password assigned to you by the provider
                'redirectUri'             => 'http://localhost:8080/backend/api/auth/oauth',
                'urlAuthorize'            => 'http://brentertainment.com/oauth2/lockdin/authorize',
                'urlAccessToken'          => 'http://brentertainment.com/oauth2/lockdin/token',
                'urlResourceOwnerDetails' => 'http://brentertainment.com/oauth2/lockdin/resource'
              ]
            );

// If we don't have an authorization code then get one
            if (!isset($_GET['code'])) {

                // Fetch the authorization URL from the provider; this returns the
                // urlAuthorize option and generates and applies any necessary parameters
                // (e.g. state).
                $authorizationUrl = $provider->getAuthorizationUrl();

                // Get the state generated for you and store it to the session.
                $_SESSION['oauth2state'] = $provider->getState();

                // Redirect the user to the authorization URL.
                header('Location: ' . $authorizationUrl);
                exit;

// Check given state against previously stored one to mitigate CSRF attack
            } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

                unset($_SESSION['oauth2state']);
                exit('Invalid state');

            } else {

                try {

                    // Try to get an access token using the authorization code grant.
                    $accessToken = $provider->getAccessToken('authorization_code', [
                      'code' => $_GET['code']
                    ]);


                    $resourceOwner = $provider->getResourceOwner($accessToken);


                    $result = [
//                      'acces_token' =>      $accessToken,
                      'resource_owner' =>   print_r($resourceOwner,TRUE)
                    ];


                    $responseBuilder->setStatusSuccess()->setJson($result);

                } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                    // Failed to get the access token or user details.
                    exit($e->getMessage());

                }

            }


        } catch(UnknownActionException $e){
            $responseBuilder
              ->setStatusBadRequest()
              ->setError($e);
        }

    }


    private function oauthVk(Request $request, GenericRESTResponseBuilder $responseBuilder){
        try{
//            http://localhost:8080/backend/api/auth/oauth/vk
            $provider = new Vk(
              [
                'clientId' => '5289954',
                'clientSecret' => 'BXjBPK8sdfYoFcYPUArK',
                'redirectUri' => 'http://localhost:8080/backend/api/auth/oauth/vk',
                'v'=> 5.45,
              ]
            );



            // If we don't have an authorization code then get one
            if (!isset($_GET['code'])) {

                // Fetch the authorization URL from the provider; this returns the
                // urlAuthorize option and generates and applies any necessary parameters
                // (e.g. state).['v'=> 5.45]
                $authorizationUrl = $provider->getAuthorizationUrl();


                // Get the state generated for you and store it to the session.
                $_SESSION['oauth2state'] = $provider->getState();

                // Redirect the user to the authorization URL.
                header('Location: ' . $authorizationUrl);

                exit;

                // Check given state against previously stored one to mitigate CSRF attack
            } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
                unset($_SESSION['oauth2state']);
                exit('Invalid state');
            }else {
                try {
                    $accessToken = $provider->getAccessToken('authorization_code', [
                      'code' => $_GET['code']
                    ]);

                    $url = $provider->getResourceOwnerDetailsUrl($accessToken);

                    $res= http_request($url);

                    var_dump($res);
//                    var_dump($accessToken);
                    die();

//                    print_r($accessToken);



                    $responseBuilder->setStatusSuccess()->setJson([$accessToken]);

                } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

                    // Failed to get the access token or user details.
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