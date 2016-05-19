<?php
namespace Domain\PostAttachment\Console\Command;

use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Repository\PostAttachmentRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

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
        $this
            ->setName('post-attachment:cleanup')
            ->setDescription('Delete all unattached attachments')
            ->addArgument(
                'timeInterval',
                InputArgument::OPTIONAL,
                'Time interval',
                $this->options["timeInterval"]
            );

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeInterval = new \DateTime();
        $timeInterval->setTimestamp(strtotime("-" . $input->getArgument('timeInterval')));

        $output->writeln('Deleting attachments since '  . $timeInterval->format(\DateTime::ISO8601) . "...");
        $helper = $this->getHelper('question');
        $unattachedAttachments = $this->postAttachmentRepository->getUnattachedAttachments($timeInterval);

        if(count($unattachedAttachments) > 0) {
            $isConfirm = $helper->ask(
                $input, $output,
                new ConfirmationQuestion("Are you sure want delete " . count($unattachedAttachments) . " records? [y/n]: ", false)
            );

            if($isConfirm) {
                $this->postAttachmentRepository->deletePostAttachments($unattachedAttachments);
            }
        } else {
            $output->writeln('Nothing to clean');
        }
    }
}