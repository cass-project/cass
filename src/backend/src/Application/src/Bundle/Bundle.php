<?php
namespace Application\Bundle;

interface Bundle
{
    public function getName();
    public function getNamespace(): string;
    public function getDir();
    public function getConfigDir();
    public function hasAPIDocsDir();
    public function getAPIDocsDir();
    public function hasBundles();
    public function getBundlesDir(): string;
    public function getContainerConfig();
    public function getResourcesDir();
}