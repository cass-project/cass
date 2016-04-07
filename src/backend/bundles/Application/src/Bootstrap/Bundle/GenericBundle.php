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

    final public function hasAPIDocsDir()
    {
        return is_dir(sprintf("%s/../api-docs", $this->getDir()));
    }

    final public function getAPIDocsDir()
    {
        if(!($this->hasAPIDocsDir())) {
            throw new \Exception(sprintf('API Docs are not available for bundle `%s`', $this->getName()));
        }

        return sprintf("%s/../api-docs", $this->getDir());
    }

    final public function getContainerConfig()
    {
        return sprintf('%s/container.config.php', $this->getConfigDir());
    }
}