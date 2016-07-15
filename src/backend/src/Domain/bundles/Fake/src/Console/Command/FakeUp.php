<?php
namespace Domain\Fake\Console\Command;

use Domain\Fake\Fixture\FakeFixture;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FakeUp extends Command
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
            ->setName('fake:up')
            ->setDescription('add fixture profiles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->fakeFixture->up($output);
    }
}