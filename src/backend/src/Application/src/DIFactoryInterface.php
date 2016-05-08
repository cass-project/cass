<?php
namespace Application;

use DI\Definition\FactoryDefinition;
use Interop\Container\ContainerInterface;

interface DIFactoryInterface
{
    public function __invoke(ContainerInterface $container, FactoryDefinition $definition);
}