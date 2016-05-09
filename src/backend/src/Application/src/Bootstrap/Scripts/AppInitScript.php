<?php
namespace Application\Bootstrap\Scripts;

use Zend\Expressive\Application;

interface AppInitScript
{
    public function __invoke(Application $app);
}