<?php
namespace Domain\Fake\Console\Command;

use Domain\Account\Service\AccountService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\Service\ProfileService;
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
//            ->addArgument()
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {
            for($var=0;$var < 10; $var++){
                $uVar = uniqid($var);
                $account = $this->accountService->createAccount("{$uVar}coffee@mail.ru",'1234');

                /** @var Profile $profile */
                $profile = $account->getCurrentProfile();
                $profile->setGender(Profile\Gender\Gender::createFromIntCode());

                $parameters = new EditPersonalParameters('n',FALSE,"first_name{$uVar}");
                $this->profileService->updatePersonalData($profile->getId(), $parameters);

            $output->writeln([
                                 "Account ID:{$account->getId()}",
                                 "Account email:{$account->getEmail()}",
                             ]);
            }

        }catch(\Exception $e) {
            $output->writeln(sprintf("%s", $e->getMessage()));
        }
    }
}