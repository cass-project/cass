<?php
namespace Domain\Account\Repository;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Exception\AccountNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Domain\Profile\Entity\Profile;

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
            throw new AccountNotFoundException(sprintf('Domain\Account with email `%s` not found', $email));
        }
    }

    public function findById(int $accountId): Account
    {
        $account = $this->find($accountId);

        if($account === null) {
            throw new AccountNotFoundException(sprintf('Account with ID `%d` not found', $accountId));
        }

        return $account;
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
        $em = $this->getEntityManager();

        $account->addProfile($profile);
        $profile->setAccount($account);
        $em->persist($account);
        $em->persist($profile);
        $em->flush([$account, $profile]);
    }

    public function requestDelete(Account $account)
    {
        $account->requestAccountDelete();

        $this->getEntityManager()->flush($account);
    }

    public function cancelDeleteRequest(Account $account)
    {
        if($account->hasDeleteAccountRequest()) {
            $account->cancelAccountRequestDelete();
        }

        $this->getEntityManager()->flush($account);
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
            throw new AccountNotFoundException(sprintf('Domain\Account with api_key `%s` not found', $apiKey));
        }

        return $account;
    }

    public function getPendingDeleteAccounts(int $days): array
    {
        /** @var Account[] $result */
        $result = $this->createQueryBuilder('account')
            ->andWhere('account.isAccountDeleteRequested = 1')
            ->andWhere(sprintf("DATE_ADD(account.dateAccountDeleteRequest, %d, 'day') <= CURRENT_DATE()", $days))
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function deleteAccount(Account $account)
    {
        $this->getEntityManager()->remove($account);
        $this->getEntityManager()->flush($account);
    }
}