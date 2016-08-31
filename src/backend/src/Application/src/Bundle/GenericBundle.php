<?php
namespace CASS\Application\Bundle;

abstract class GenericBundle implements Bundle
{
    final public function getName()
    {
        return static::class;
    }

    public function getNamespace(): string {
        return substr(get_called_class(), 0, strrpos(get_called_class(), "\\"));
    }

    public function hasBundles() {
        return is_dir($this->getDir().'/../bundles');
    }

    public function getBundlesDir(): string {
        if(! $this->hasBundles()) {
            throw new \Exception('No bundles available');
        }

        return $this->getDir().'/../bundles';
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

    public function hasResources(){
        return is_dir($this->getDir() . '/../resources');
    }

    public function getResourcesDir(): string{
        if(!$this->hasResources()){
            throw new \Exception('No resources available');
        }

        return $this->getDir() . '/../resources';
    }
}