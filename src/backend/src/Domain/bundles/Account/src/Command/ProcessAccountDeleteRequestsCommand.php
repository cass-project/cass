<?php
namespace Domain\Account\Command;

use Domain\Account\Scripts\ProcessAccountDeleteRequestsScript;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessAccountDeleteRequestsCommand extends Command
{
    /** @var ProcessAccountDeleteRequestsScript */
    private $script;

    public function __construct(ProcessAccountDeleteRequestsScript $script)
    {
        $this->script = $script;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('account:process-delete-requests')
            ->setDescription('Delete account which pending for deletions');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $script = $this->script;
        $script();
    }
}