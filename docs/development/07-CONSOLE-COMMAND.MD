Добавление консольных комманд
=============================

- Создайте консольную комманду в бандле, в котором вы работаете, в поднеймспейсе Console:

```php
<?php
namespace Domain\Profile\Console\Command;

use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\Profile\Service\ProfileService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProfileCard extends Command
{
    /** @var ProfileService */
    private $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('profile:card')
            ->setDescription('ProfleBundle: show profile card')
            ->addArgument('id', InputArgument::REQUIRED, 'Domain\Profile ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $profileId = (int) $input->getArgument('id');

        try {
            $profile = $this->profileService->getProfileById($profileId);

            $output->writeln([
                "Domain\Profile(#{$profile->getId()}): ",
                "-----",
                "AccountID: {$profile->getAccount()->getId()}",
                "Greetings: {$profile->getProfileGreetings()->getGreetings()}",
                "-----",
            ]);
        }catch(ProfileNotFoundException $e) {
            $output->writeln(sprintf("Domain\Profile with id `%d` not found", $profileId));
        }
    }
}
```

- Добавьте конфигурацию в `{BundleName}/config/container.config.php`:для того, чтобы php-di контейнер мог создать инстанс этого класса:

```php
<?php
use Domain\Profile\Console\Command\ProfileCard;

use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        // ....
        ProfileCard::class => object()->constructor(
            get(ProfileService::class)
        )
    ],
];
```

- Добавьте информацию о команде в `{BundleName}/config/console.config.php`:

```
<?php
use Domain\Profile\Console\Command\ProfileCard;

return [
    'console' => [
        'commands' => [
            'profile' => [
                ProfileCard::class
            ]
        ]
    ]
];
```