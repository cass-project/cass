<?php
namespace EmailVerification\Console\Command;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AQMPReceive extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('amqp:receive')
            ->setDescription('Receive message via AMQP')
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
        $channelName = $input->getOption('channel');

        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($channelName);

        $channel->basic_consume($channelName, '', false, true, false, false, function(AMQPMessage $msg) use ($output) {
            $this->clearScreen($output)
                 ->write($msg->body);
        });

        $this->clearScreen($output)->write("Waiting for...");
        while(count($channel->callbacks)) {
            $channel->wait();
        }
    }

    private function clearScreen(OutputInterface $output)
    {
        $output->write("\033\143");
        return $output;
    }
}