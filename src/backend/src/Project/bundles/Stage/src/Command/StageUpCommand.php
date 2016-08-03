<?php
namespace CASS\Project\Bundles\Stage\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class StageUpCommand extends Command
{
    /** @var FakeFixture */
    private $fakeFixture;

    public function __construct(FakeFixture $fakeFixture)
    {
        $this->fakeFixture = $fakeFixture;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('stage:fake')
            ->setDescription('Stage fake data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fakeFixture->up($output);
    }
}