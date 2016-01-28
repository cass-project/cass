<?php
namespace Square;

use Application\Bootstrap\Bundle\Bundle;

class SquareBundle implements Bundle
{
    public function getName()
    {
        return self::class;
    }

    public function getDir()
    {
        return __DIR__;
    }

    public function getConfigDir()
    {
        return __DIR__.'/../config';
    }

    public function getContainerConfig()
    {
        return sprintf('%s/container.config.php', $this->getConfigDir());
    }
}