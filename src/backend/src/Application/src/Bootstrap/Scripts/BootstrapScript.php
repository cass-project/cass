<?php
namespace CASS\Application\Bootstrap\Scripts;

use CASS\Application\Bootstrap\AppBuilder;

interface BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder);
}