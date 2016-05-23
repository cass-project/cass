<?php
namespace Domain\Account;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Account\Command\DeleteAccountCommand;
use Domain\Account\Command\ProcessAccountDeleteRequestsCommand;
use Domain\Account\Entity\Account;
use Domain\Account\Entity\OAuthAccount;
use Domain\Account\Middleware\Command\CancelDeleteRequestCommand;
use Domain\Account\Middleware\Command\ChangePasswordCommand;
use Domain\Account\Middleware\Command\DeleteRequestCommand;
use Domain\Account\Repository\AccountRepository;
use Domain\Account\Repository\OAuthAccountRepository;
use Domain\Account\Scripts\DeleteAccountScript;
use Domain\Account\Scripts\ProcessAccountDeleteRequestsScript;
use Domain\Account\Service\AccountService;
use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Auth\Service\AuthService;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Auth\Service\PasswordVerifyService;
use Domain\Profile\Repository\ProfileGreetingsRepository;

return [
    'php-di' => [
        AccountService::class => object()->constructor(
            get(AccountRepository::class),
            get(OAuthAccountRepository::class),
            get(ProfileGreetingsRepository::class),
            get(PasswordVerifyService::class)
        ),
        AccountRepository::class => factory(new DoctrineRepositoryFactory(Account::class)),
        OAuthAccountRepository::class => factory(new DoctrineRepositoryFactory(OAuthAccount::class)),
        ProcessAccountDeleteRequestsScript::class => object()->constructor(
            get(DeleteAccountScript::class),
            get(AccountRepository::class)
        ),
        DeleteAccountScript::class => object()->constructor(
            get(AccountRepository::class)
        ),
        DeleteAccountCommand::class => object()->constructor(
            get(DeleteAccountScript::class)
        ),
        ProcessAccountDeleteRequestsCommand::class => object()->constructor(
            get(ProcessAccountDeleteRequestsScript::class)
        ),
        DeleteRequestCommand::class => object()->constructor(
            get(AccountService::class),
            get(CurrentAccountService::class)
        ),
        CancelDeleteRequestCommand::class => object()->constructor(
            get(AccountService::class),
            get(CurrentAccountService::class)
        ),
        ChangePasswordCommand::class => object()->constructor(
            get(AccountService::class),
            get(CurrentAccountService::class),
            get(AuthService::class)
        ),
    ]
];