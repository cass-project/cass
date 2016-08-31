<?php
namespace CASS\Application;

use Interop\Container\ContainerInterface;

interface DIFactoryInterface
{
    public function __invoke(ContainerInterface $container);
}