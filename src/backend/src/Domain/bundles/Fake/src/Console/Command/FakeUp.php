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
            $profilesJsonFile = sprintf("%s/../../Resources/Data/JSON/profiles.json",__DIR__);
            if(!file_exists($profilesJsonFile)) $output->writeln(['Файл не сущестуует']);

            $profilesJson = json_decode( file_get_contents($profilesJsonFile) );

            foreach($profilesJson as $profileJson){

                $avatarPath = sprintf("%s/../../Resources/Data/Images/avatars/%s", __DIR__, $profileJson->avatar);

                $account = $this->accountService->createAccount($profileJson->email,'1234');
                /** @var Profile $profile */
                $profile = $account->getCurrentProfile();
                $profile->setGender(Profile\Gender\Gender::createFromIntCode((int)$profileJson->gender));
                $parameters = new EditPersonalParameters(
                    'n', file_exists($avatarPath)? $avatarPath: FALSE,
                    $profileJson->nickname == NULL ? '' : $profileJson->nickname,
                    $profileJson->surname == NULL ? '' : $profileJson->surname,
                    $profileJson->patronymic == NULL ? '' : $profileJson->patronymic,
                    $profileJson->nickname == NULL ? '' : $profileJson->nickname
                );
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