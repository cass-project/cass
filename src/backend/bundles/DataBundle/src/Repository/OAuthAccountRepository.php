<?php
namespace Data\Repository;

use Auth\Service\AuthService\OAuth2\RegistrationRequest;
use Data\Entity\Account;
use Data\Entity\OAuthAccount;
use Data\Exception\Auth\AccountNotFoundException;
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

    public function create(RegistrationRequest $registrationRequest)
    {
        $em = $this->getEntityManager();

        $account = new Account();
        $account->setEmail($registrationRequest->getEmail());
        $account->setPassword(md5(rand(0, 99999999)));

        $oauthAccount = new OAuthAccount();
        $oauthAccount->setAccount($account);
        $oauthAccount->setProvider($registrationRequest->getProvider());
        $oauthAccount->setProviderAccountId($registrationRequest->getProviderAccountId());

        $em->persist($oauthAccount);
        $em->flush($oauthAccount);
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