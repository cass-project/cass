<?php
namespace Account\Repository;

use Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Account\Entity\OAuthAccount;
use Account\Exception\AccountNotFoundException;
use Doctrine\ORM\EntityRepository;

class OAuthAccountRepository extends EntityRepository
{
    public function hasAccountWithEmail(string $email): bool
    {
        return count($this->findBy([
            'email' => $email
        ])) > 0;
    }

    public function getAccountWith(RegistrationRequest $registrationRequest): OAuthAccount
    {
        return $this->findOneBy([
            'email' => $registrationRequest->getEmail(),
            'provider' => $registrationRequest->getProvider(),
            'providerAccountId' => $registrationRequest->getProviderAccountId()
        ]);
    }

    public function findOAuthAccount($provider, $providerAccountId): OAuthAccount
    {
        $result = $this->findOneBy([
            'provider' => $provider,
            'providerAccountId' => $providerAccountId
        ]);

        if($result === null) {
            throw new AccountNotFoundException(sprintf('Account `OAUTH2#%s@%s` not found', $providerAccountId, $provider));
        }

        return $result;
    }
}