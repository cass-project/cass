<?php
namespace Application\Bootstrap\Bundle;

interface Bundle
{
    public function getName();
    public function getDir();
    public function getConfigDir();
    public function getContainerConfig();
}