<?php
namespace Application\Auth\Middleware\Command\OAuth;

use Application\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Depotwarehouse\OAuth2\Client\Entity\WowUser;
use Depotwarehouse\OAuth2\Client\Provider\WowProvider;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class BattleNetCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new WowProvider($this->getOauth2Config());
    }

    protected function makeRegistrationRequest(AbstractProvider $provider, AccessToken $accessToken): RegistrationRequest
    {
        /** @var WowUser $resourceOwner */
        $resourceOwner = $provider->getResourceOwner($accessToken);

        var_dump($resourceOwner->toArray());
        die();
    }
}