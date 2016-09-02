<?php
namespace CASS\Domain\Bundles\Profile\Console\Command;

use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
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
            ->setDescription('ProfileBundle: show profile card')
            ->addArgument('id', InputArgument::REQUIRED, 'CASS\Domain\Bundles\Profile ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $profileId = (int) $input->getArgument('id');

        try {
            $profile = $this->profileService->getProfileById($profileId);

            $output->writeln([
                "Profile(#{$profile->getId()}): ",
                "-----",
                "AccountID: {$profile->getAccount()->getId()}",
                "Greetings: {$profile->getGreetings()->toJSON()}",
                "-----",
            ]);
        }catch(ProfileNotFoundException $e) {
            $output->writeln(sprintf("Profile with id `%d` not found", $profileId));
        }
    }
}