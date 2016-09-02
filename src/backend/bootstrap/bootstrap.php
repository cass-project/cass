<?php
define('APP_TIMER_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

return (new \CASS\Application\Bootstrap\AppBuilder([
    new \CASS\Application\ApplicationBundle(),
    new \Domain\DomainBundle(),
    new \CASS\Util\UtilBundle(),
]))->build();
