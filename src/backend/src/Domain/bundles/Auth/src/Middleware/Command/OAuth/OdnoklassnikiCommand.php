<?php
namespace Domain\Auth\Middleware\Command\OAuth;

use CASS\Application\Exception\NotImplementedException;
use Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class OdnoklassnikiCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        throw new NotImplementedException;
    }

    protected function makeRegistrationRequest(AbstractProvider $provider, AccessToken $accessToken): RegistrationRequest {
        throw new NotImplementedException;
    }
}