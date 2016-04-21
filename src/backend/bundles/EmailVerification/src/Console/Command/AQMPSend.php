<?php
namespace EmailVerification\Console\Command;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AQMPSend extends Command
{
    private $connection;
    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('amqp:send')
            ->setDescription('Send message via AMQP')
            ->addArgument('text', InputArgument::REQUIRED, 'Message text')
            ->addOption(
                'channel',
                'c',
                InputOption::VALUE_REQUIRED,
                'Channel name',
                'general'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = $input->getArgument('text');
        $channelName = $input->getOption('channel');

        $channel = $this->connection->channel();
        $channel->queue_declare($channelName);
        $channel->basic_publish(
            new AMQPMessage($text, ["timestamp"=>time()]),
            '',
            $channelName
        );


        $output->writeln("Success");
    }
}