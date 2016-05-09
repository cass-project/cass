<?php
require __DIR__.'/vendor/autoload.php';

return (new \Application\Bootstrap\AppBuilder([
    new \Application\ApplicationBundle(),
    new \Domain\DomainBundle()
]))->build();
