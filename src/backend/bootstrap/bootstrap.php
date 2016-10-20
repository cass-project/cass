<?php
define('APP_TIMER_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

return (new \CASS\Application\Bootstrap\AppBuilder([
    new \ZEA2\Platform\PlatformBundle(),
    new \CASS\Application\ApplicationBundle(),
    new \CASS\Domain\DomainBundle(),
    new \CASS\Util\UtilBundle(),
    new CASS\Chat\ChatBundle()
]))->build();
