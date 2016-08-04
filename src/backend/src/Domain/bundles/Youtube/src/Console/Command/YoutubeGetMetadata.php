<?php

namespace Domain\Youtube\Console\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class YoutubeGetMetadata extends Command
{
    private $configOauth2Google;

    public function __construct(array $configOauth2Google){
        $this->configOauth2Google = $configOauth2Google;
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('youtube:get:metadata')
            ->setDescription('loads video metadata from youtube');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

    }



}