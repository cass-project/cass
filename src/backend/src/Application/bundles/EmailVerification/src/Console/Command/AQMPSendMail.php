<?php
namespace Application\EmailVerification\Console\Command;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AQMPSendMail extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('amqp:sendMail')->setDescription('Send email via AMQP');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('sendMail');

        $channel->basic_consume('sendMail', '', false, true, false, false, function(AMQPMessage $msg) use ($output) {
            $body = json_decode($msg->body, true);
            mail($body['to'], $body['subject'], $body['message']);
            $this->clearScreen($output)->write($msg->body);
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