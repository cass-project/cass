<?php
namespace CASS\Domain\Account\Command;

use CASS\Domain\Account\Scripts\DeleteAccountScript;
use CASS\Domain\Account\Service\AccountService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteAccountCommand extends Command
{
    /** @var DeleteAccountScript */
    private $deleteAccountScript;

    /** @var AccountService */
    private $accountService;

    public function __construct(DeleteAccountScript $deleteAccountScript, AccountService $accountService)
    {
        $this->deleteAccountScript = $deleteAccountScript;
        $this->accountService = $accountService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('account:delete')
            ->setDescription('Delete account')
            ->addArgument(
                'id',
                InputArgument::REQUIRED,
                'Account ID'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $accountId = $input->getArgument('id');

        if (!is_numeric($accountId)) {
            throw new \InvalidArgumentException('Invalid id');
        }

        $this->accountService->deleteAccount($accountId);
    }
}