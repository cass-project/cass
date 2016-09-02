<?php
namespace CASS\Domain\Bundles\Auth\Middleware\Command\OAuth;

use CASS\Domain\Bundles\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;

class GoogleCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new Google($this->getOauth2Config());
    }

    protected function makeRegistrationRequest(AbstractProvider $provider, AccessToken $accessToken): RegistrationRequest
    {
        /** @var GoogleUser $resourceOwner */
        $resourceOwner = $provider->getResourceOwner($accessToken);

        $email = $resourceOwner->getEmail();
        $providerAccountId = (string) $resourceOwner->getId();

        return new RegistrationRequest('google', $providerAccountId, $email,$resourceOwner);
    }
}