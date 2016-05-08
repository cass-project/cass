<?php
namespace Application\Profile\Console\Command;

use Application\Profile\Exception\ProfileNotFoundException;
use Application\Profile\Service\ProfileService;
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
            ->addArgument('id', InputArgument::REQUIRED, 'Application\Profile ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $profileId = (int) $input->getArgument('id');

        try {
            $profile = $this->profileService->getProfileById($profileId);

            $output->writeln([
                "Application\Profile(#{$profile->getId()}): ",
                "-----",
                "AccountID: {$profile->getAccount()->getId()}",
                "Greetings: {$profile->getProfileGreetings()->getGreetings()}",
                "-----",
            ]);
        }catch(ProfileNotFoundException $e) {
            $output->writeln(sprintf("Application\Profile with id `%d` not found", $profileId));
        }
    }
}