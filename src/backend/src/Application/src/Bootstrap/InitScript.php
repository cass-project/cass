<?php
namespace Application\Bootstrap;

use Application\Bootstrap\AppBuilder;

interface InitScript
{
    public function __invoke(AppBuilder $appBuilder);
}