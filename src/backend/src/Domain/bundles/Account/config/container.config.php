<?php
namespace CASS\Domain\Account;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Domain\Account\Entity\Account;
use CASS\Domain\Account\Entity\AccountAppAccess;
use CASS\Domain\Account\Entity\OAuthAccount;
use CASS\Domain\Account\Repository\AccountAppAccessRepository;
use CASS\Domain\Account\Repository\AccountRepository;
use CASS\Domain\Account\Repository\OAuthAccountRepository;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        AccountRepository::class => factory(new DoctrineRepositoryFactory(Account::class)),
        OAuthAccountRepository::class => factory(new DoctrineRepositoryFactory(OAuthAccount::class)),
        AccountAppAccessRepository::class => factory(new DoctrineRepositoryFactory(AccountAppAccess::class)),
    ]
];