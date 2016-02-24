<?php
namespace Auth\Middleware\Command\OAuth;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use League\OAuth2\Client\Provider\Google;
use Psr\Http\Message\ServerRequestInterface;

class GoogleCommand extends Command
{
    public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder)
    {

        $provider = new Google(
          [
            'clientId'     => '992284499181-ccsf7gh4ucck8348g9kaimqs2s9i2fjt.apps.googleusercontent.com',
            'clientSecret' => 'VLSX8IMfFfkAll-dAtiEkUiZ',
            'redirectUri'  => 'http://localhost:8080/backend/api/auth/oauth/google',
            'hostedDomain' => 'localhost:8080',
          ]
        );

        if (!empty($_GET['error'])) {

            // Got an error, probably user denied access
            exit('Got error: ' . $_GET['error']);

        } elseif (empty($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            header('Location: ' . $authUrl);
            exit;

        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

            // State is invalid, possible CSRF attack in progress
            unset($_SESSION['oauth2state']);
            exit('Invalid state');

        } else {

            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
              'code' => $_GET['code']
            ]);

            // Optional: Now you have a token you can look up a users profile data
            try {

                // We got an access token, let's now get the owner details
                $ownerDetails = $provider->getResourceOwner($token);

                // Use these details to create a new profile
                $responseBuilder->setStatusSuccess()
                                ->setJson([$ownerDetails]);

            } catch (\Exception $e) {

                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());

            }
        }
    }
}