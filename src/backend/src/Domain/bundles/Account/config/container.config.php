<?php
namespace CASS\Domain\Bundles\Account;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Account\Entity\AccountAppAccess;
use CASS\Domain\Bundles\Account\Entity\OAuthAccount;
use CASS\Domain\Bundles\Account\Repository\AccountAppAccessRepository;
use CASS\Domain\Bundles\Account\Repository\AccountRepository;
use CASS\Domain\Bundles\Account\Repository\OAuthAccountRepository;
use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        AccountRepository::class => factory(new DoctrineRepositoryFactory(Account::class)),
        OAuthAccountRepository::class => factory(new DoctrineRepositoryFactory(OAuthAccount::class)),
        AccountAppAccessRepository::class => factory(new DoctrineRepositoryFactory(AccountAppAccess::class)),
    ]
];