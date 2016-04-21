<?php
namespace Common\Factory;

use Common\Service\SharedConfigService;
use Interop\Container\ContainerInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AMQPStreamConnectionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $sharedConfigService = $container->get(SharedConfigService::class); /** @var SharedConfigService $sharedConfigService */
        $config = $sharedConfigService->get('amqp');

        return new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['pass']);
    }
}