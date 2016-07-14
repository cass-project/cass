<?php

use \Domain\Fake\Console\Command\FakeUp;
use \Domain\Account\Service\AccountService;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        FakeUp::class => object()->constructor(
           get(AccountService::class)
        )
    ],
];