<?php
namespace Application\Bundle;

abstract class GenericBundle implements Bundle
{
    final public function getName()
    {
        return static::class;
    }

    public function hasBundles() {
        return is_dir($this->getDir().'/../bundles');
    }

    public function getBundles(): array {
        $bundlesPath = $this->getDir().'/../bundles';

        if(! $this->hasBundles()) {
            throw new \Exception('No bundles available');
        }

        $bundleDirs = array_filter(scandir($bundlesPath), function ($input) use ($bundlesPath) {
            return $input != '.' && $input != '..' && is_dir(sprintf('%s/%s', $bundlesPath, $input));
        });

        return array_map(function(string $bundleDir) use ($bundlesPath) {
            return [
                'name' => $bundleDir,
                'path' => sprintf('%s/%s', $bundlesPath, $bundleDir)
            ];
        }, $bundleDirs);
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