<?php
namespace CASS\Project\Bundles\Stage\Command;

use CASS\Project\Bundles\Stage\Fixture\ThemeFixture;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class StageThemesCommand extends Command
{
    /** @var ThemeFixture */
    private $themeFixture;

    public function __construct(ThemeFixture $themeFixture)
    {
        $this->themeFixture = $themeFixture;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('stage:demo')
            ->setDescription('Stage&Production themes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->themeFixture->up($output);
    }
}