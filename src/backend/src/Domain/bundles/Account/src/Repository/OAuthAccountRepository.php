<?php
namespace Domain\Account\Repository;

use Domain\Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Exception\AccountNotFoundException;
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
            throw new AccountNotFoundException(sprintf('Domain\Account `OAUTH2#%s@%s` not found', $providerAccountId, $provider));
        }

        return $result;
    }
}