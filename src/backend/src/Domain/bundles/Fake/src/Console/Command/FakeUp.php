<?php
namespace Domain\Fake\Console\Command;

use Application\Util\Definitions\Point;
use Domain\Account\Service\AccountService;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Fake\Console\Command\DataHandler\ProfilesHandler;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\Service\ProfileService;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeUp extends Command
{

    /** @var AccountService $accountService */
    private $accountService;
    private $profileService;

    public function __construct(AccountService $accountService, ProfileService $profileService)
    {
        $this->profileService = $profileService;
        $this->accountService = $accountService;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('fake:up')
            ->setDescription('add fixture profiles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $dataHandler = new ProfilesHandler($this->accountService, $this->profileService, $output);
            $dataHandler->readData(__DIR__ . "/../../Resources/Data/JSON/profiles.json")
            ->saveData();

        }catch(\Exception $e) {
            $output->writeln(sprintf("%s", $e->getMessage()));
        }
    }
}