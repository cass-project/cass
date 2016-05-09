<?php
namespace Application\Bootstrap\Scripts\AppInit;

use Application\Bootstrap\AppBuilder;
use Zend\Expressive\Application;

interface AppInit
{
    public function __invoke(Application $app);
}