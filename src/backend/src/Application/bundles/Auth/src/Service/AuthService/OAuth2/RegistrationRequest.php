<?php
namespace Application\Auth\Service\AuthService\OAuth2;

class RegistrationRequest
{
    /** @var string */
    private $provider;

    /** @var string */
    private $providerAccountId;

    /** @var string */
    private $email;

    public function __construct(string $provider, string $providerAccountId, string $email)
    {
        $this->providerAccountId = $providerAccountId;
        $this->provider = $provider;
        $this->email = $email;
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
}