<?php
namespace CASS\Application\Bundles\Stage\Command;

use CASS\Application\Bundles\Stage\Fixture\ThemeFixture;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class StageThemesCommand extends Command
{
    /** @var ThemeFixture */
    private $themesFixture;
    
    public function __construct(ThemeFixture $themesFixture)
    {
        $this->themesFixture = $themesFixture;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('stage:themes:migrate')
            ->setDescription('Stage themes data');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->themesFixture->up($output);
    }
}