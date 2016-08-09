<?php
namespace Domain\Account\Repository;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Exception\AccountNotFoundException;
use Doctrine\ORM\EntityRepository;
use Domain\Profile\Entity\Profile\Greetings;

class AccountRepository extends EntityRepository
{
    public function createAccount(Account $account): Account
    {
        $em = $this->getEntityManager();

        $em->persist($account);
        $em->flush($account);

        return $account;
    }

    public function saveAccount(Account $account): Account
    {
        $this->getEntityManager()->flush($account);

        return $account;
    }

    public function createOAuth2Account(OAuthAccount $OAuth2Account): OAuthAccount
    {
        $this->getEntityManager()->persist($OAuth2Account);
        $this->getEntityManager()->flush($OAuth2Account);

        return $OAuth2Account;
    }

    public function deleteAccount(Account $account)
    {
        $this->getEntityManager()->remove($account);
        $this->getEntityManager()->flush($account);
    }

    public function getByEmail(string $email): Account
    {
        $account = $this->findOneBy([
            'email' => $email
        ]);

        if ($account === null) {
            throw new AccountNotFoundException(sprintf('Account with email `%s` not found', $email));
        }

        return $account;
    }

    public function getById(int $accountId): Account
    {
        $account = $this->find($accountId);

        if ($account === null) {
            throw new AccountNotFoundException(sprintf('Account with ID `%d` not found', $accountId));
        }

        return $account;
    }

    public function hasAccountWithEmail($email) : bool
    {
        return $this->findOneBy([
            'email' => $email
        ]) !== null;
    }

    public function findByAPIKey(string $apiKey): Account
    {
        $account = $this->findOneBy([
            'apiKey' => $apiKey
        ]);

        if ($account === null) {
            throw new AccountNotFoundException(sprintf('Domain\Account with api_key `%s` not found', $apiKey));
        }

        return $account;
    }
    
    public function hasAccountWithAPIKey(string $apiKey): bool 
    {
        return $this->findOneBy([
            'apiKey' => $apiKey
        ]) !== null;
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
}