<?php
namespace Application\Auth\Middleware\Command\OAuth;

use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Auth\Middleware\Command\Command;
use Application\Auth\Service\AuthService\OAuth2\RegistrationRequest;
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