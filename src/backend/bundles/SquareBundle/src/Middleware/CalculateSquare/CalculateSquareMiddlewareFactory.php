<?php
namespace Square\Middleware\CalculateSquare;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CalculateSquareMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CalculateSquareMiddleware(
            $container->get('Square\Service\Square\SquareService')
        );
    }
}