<?php
namespace Common\Bootstrap\Bundle;

interface Bundle
{
    public function getName();
    public function getDir();
    public function getConfigDir();
    public function hasAPIDocsDir();
    public function getAPIDocsDir();
    public function getContainerConfig();
}