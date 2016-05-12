<?php
namespace Domain\PostAttachment\Console\Command;

use Domain\PostAttachment\Repository\PostAttachmentRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PostAttachmentCleanup extends Command
{
    private $options;
    private $postAttachmentRepository;

    public function __construct($config, PostAttachmentRepository $postAttachmentRepository)
    {
        $this->options = $config["cleanup_options"];
        $this->postAttachmentRepository = $postAttachmentRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('post-attachment:cleanup')
            ->setDescription('Delete all unattached attachments')
            ->addOption(
                'time',
                't',
                InputOption::VALUE_OPTIONAL,
                'Time interval',
                $this->options["timeInterval"]
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Deleting data since " . $input->getOption('time'));

//$this->postAttachmentRepository->deletePostAttachments();
        $timeInterval = strtotime($input->getOption('time'));

        $output->writeln($timeInterval);
    }
}