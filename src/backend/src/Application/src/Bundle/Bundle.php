<?php
namespace Application\Bundle;

interface Bundle
{
    public function getName();
    public function getDir();
    public function getConfigDir();
    public function hasAPIDocsDir();
    public function getAPIDocsDir();
    public function hasBundles();
    public function getBundles(): array;
    public function getContainerConfig();
}