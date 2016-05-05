<?php
namespace Auth\Service\AuthService\OAuth2;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class RegistrationRequest
{
    /** @var string */
    private $provider;

    /** @var string */
    private $providerAccountId;

    /** @var string */
    private $email;

    /** @var ResourceOwnerInterface */
    private $resourceOwner;

    public function __construct(string $provider, string $providerAccountId, string $email, ResourceOwnerInterface $resourceOwner = null )
    {
        $this->providerAccountId = $providerAccountId;
        $this->provider = $provider;
        $this->email = $email;
        $this->resourceOwner = $resourceOwner;
    }

    public function getProviderAccountId(): string
    {
        return $this->providerAccountId;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getResourceOwner()
    {
        return $this->resourceOwner;
    }
}