<?php
namespace Domain\Account;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\AccountAppAccess;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Repository\AccountAppAccessRepository;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        AccountRepository::class => factory(new DoctrineRepositoryFactory(Account::class)),
        OAuthAccountRepository::class => factory(new DoctrineRepositoryFactory(OAuthAccount::class)),
        AccountAppAccessRepository::class => factory(new DoctrineRepositoryFactory(AccountAppAccess::class)),
    ]
];