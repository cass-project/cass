<?php
namespace Domain\Account;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
    'php-di' => [
        AccountRepository::class => factory(new DoctrineRepositoryFactory(Account::class)),
        OAuthAccountRepository::class => factory(new DoctrineRepositoryFactory(OAuthAccount::class)),
    ]
];