<?php
namespace CASS\Application\Bundles\Stage\Command;

use CASS\Application\Bundles\Stage\Fixture\DemoFixture;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class StageDemoSyncCommand extends Command
{
    /** @var DemoFixture */
    private $demoFixture;

    public function __construct(DemoFixture $demoFixture)
    {
        $this->demoFixture = $demoFixture;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('stage:demo:sync')
            ->setDescription('Sync stage demo data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->demoFixture->sync($output);
    }
}