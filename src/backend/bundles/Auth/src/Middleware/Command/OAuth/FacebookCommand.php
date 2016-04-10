<?php
namespace Auth\Middleware\Command\OAuth;

use Common\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Auth\Service\AuthService\OAuth2\RegistrationRequest;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Provider\FacebookUser;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ServerRequestInterface;

class FacebookCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new Facebook($this->getOauth2Config());
    }

    protected function makeRegistrationRequest(AbstractProvider $provider, AccessToken $accessToken): RegistrationRequest
    {
        /** @var FacebookUser $resourceOwner */
        $resourceOwner = $provider->getResourceOwner($accessToken);

        return new RegistrationRequest('facebook', $resourceOwner->getId(), $resourceOwner->getEmail());
    }
}