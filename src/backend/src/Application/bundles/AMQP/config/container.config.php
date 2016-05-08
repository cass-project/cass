<?php
namespace Application\AMQP;

use function DI\object;
use function DI\factory;
use function DI\get;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Application\AMQP\Factory\AMQPStreamConnectionFactory;

return [
    'php-di' => [
        AMQPStreamConnection::class => factory(AMQPStreamConnectionFactory::class)
    ]
];