<?php
namespace Domain\Account;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use Domain\Account\Service\AccountService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Profile\Repository\ProfileGreetingsRepository;

return [
    'php-di' => [
        AccountService::class => object()->constructor(
            get(AccountRepository::class),
            get(OAuthAccountRepository::class),
            get(ProfileGreetingsRepository::class)
        ),
        AccountRepository::class => factory(new DoctrineRepositoryFactory(Account::class)),
        OAuthAccountRepository::class => factory(new DoctrineRepositoryFactory(OAuthAccount::class)),
    ]
];