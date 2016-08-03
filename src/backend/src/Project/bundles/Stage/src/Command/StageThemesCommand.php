<?php
namespace CASS\Project\Bundles\Stage\Command;

use CASS\Project\Bundles\Stage\Fixture\DemoFixture;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class StageThemesCommand extends Command
{
    /** @var DemoFixture */
    private $fakeFixture;

    public function __construct(DemoFixture $demoFixture)
    {
        $this->fakeFixture = $demoFixture;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('stage:demo')
            ->setDescription('Stage demo profiles, collections and posts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fakeFixture->up($output);
    }
}