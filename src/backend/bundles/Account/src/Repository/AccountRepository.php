<?php
namespace Account\Repository;

use Account\Entity\Account;
use Account\Entity\OAuthAccount;
use Data\Exception\Auth\AccountNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Profile\Entity\Profile;

class AccountRepository extends EntityRepository
{
    public function findByEmail($email) : Account
    {
        try {
            return $this->createQueryBuilder('a')
                ->where('a.email = :email')
                ->setParameter("email", $email)
                ->getQuery()
                ->getSingleResult()
            ;
        }catch (NoResultException $e) {
            throw new AccountNotFoundException(sprintf('Account with email `%s` not found', $email));
        }
    }

    public function hasAccountWithEmail($email) : bool
    {
        try {
            $this->findByEmail($email);

            return true;
        }catch(AccountNotFoundException $e) {
            return false;
        }
    }

    public function saveAccount(Account $account, Profile $profile)
    {
        $this->getEntityManager()->persist($account);
        $this->getEntityManager()->persist($profile);
        $this->getEntityManager()->flush([$account, $profile]);
    }

    public function saveOAuth2Account(OAuthAccount $OAuth2Account)
    {
        $this->getEntityManager()->persist($OAuth2Account);
        $this->getEntityManager()->flush($OAuth2Account);
    }

    public function findByAPIKey(string $apiKey)
    {
        $account = $this->findOneBy([
            'password' => $apiKey
        ]);

        if($account === null) {
            throw new AccountNotFoundException(sprintf('Account with api_key `%s` not found', $apiKey));
        }

        return $account;
    }
}