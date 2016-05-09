<?php
namespace Application\Bootstrap\Scripts;

use Application\Bootstrap\AppBuilder;

interface BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder);
}