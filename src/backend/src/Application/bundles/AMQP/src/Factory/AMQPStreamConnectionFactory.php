<?php
namespace Application\AMQP\Factory;

use Interop\Container\ContainerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AMQPStreamConnectionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config.amqp');

        return new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['pass']);
    }
}