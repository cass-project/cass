<?php
namespace Domain\Fake\Console\Command;

use Domain\Account\Service\AccountService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FakeUp extends Command
{

    /** @var AccountService $accountService */
    private $accountService;

    public function __construct(AccountService $accountService)
    {
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
                $account = $this->accountService->createAccount("{$var}coffee@mail.ru",'1234');

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