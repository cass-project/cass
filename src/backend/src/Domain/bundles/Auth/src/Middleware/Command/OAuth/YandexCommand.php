<?php
namespace CASS\Domain\Bundles\Auth\Middleware\Command\OAuth;

use CASS\Application\Exception\NotImplementedException;
use CASS\Domain\Bundles\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class YandexCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        throw new NotImplementedException;
    }

    protected function makeRegistrationRequest(AbstractProvider $provider, AccessToken $accessToken): RegistrationRequest {
        throw new NotImplementedException;
    }
}