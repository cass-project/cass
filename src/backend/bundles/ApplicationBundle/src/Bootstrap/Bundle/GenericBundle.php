<?php
namespace Application\Bootstrap\Bundle;

abstract class GenericBundle implements Bundle
{
    final public function getName()
    {
        return static::class;
    }

    final public function getConfigDir()
    {
        return sprintf("%s/../config", $this->getDir());
    }

    final public function getContainerConfig()
    {
        return sprintf('%s/container.config.php', $this->getConfigDir());
    }

}