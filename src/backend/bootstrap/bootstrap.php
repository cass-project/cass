<?php
define('APP_TIMER_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

return (new \Application\Bootstrap\AppBuilder([
    new \Application\ApplicationBundle(),
    new \Domain\DomainBundle(),
    new \CASS\Project\ProjectBundle(),
]))->build();
