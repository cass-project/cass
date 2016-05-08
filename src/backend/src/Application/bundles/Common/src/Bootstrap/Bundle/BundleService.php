<?php
namespace Application\Common\Bootstrap\Bundle;

class BundleService
{
    /**
     * @var Bundle[]
     */
    private $bundles;

    /**
     * @var string[]
     */
    private $configDirs;

    public function addBundle(Bundle $bundle) {
        $this->bundles[] = $bundle;
    }

    public function getBundles() {
        return $this->bundles;
    }

    public function getConfigDirs() {
        if($this->configDirs === null) {
            $this->configDirs = array_map(function(Bundle $bundle) {
                return $bundle->getConfigDir();
            }, $this->getBundles());
        }

        return $this->configDirs;
    }

    public function getBundleByName($bundleName) {
        foreach($this->bundles as $bundle) {
            if($bundle->getName() === $bundleName) {
                return $bundle;
            }
        }

        throw new \OutOfBoundsException(sprintf('Bundle `%s` not found'));
    }
}

