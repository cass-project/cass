<?php
namespace {
    require __DIR__ . '/../vendor/autoload.php';
}

namespace PhpUnitBootstrap
{
    use CASS\Application\ApplicationBundle;
    use CASS\Application\Bootstrap\AppBuilder;
    use CASS\Application\Bundles\PHPUnit\TestCase\CASSMiddlewareTestCase;
    use CASS\Util\UtilBundle;
    use Domain\DomainBundle;

    $app = (new AppBuilder([
        new ApplicationBundle(),
        new DomainBundle(),
        new UtilBundle(),
    ]))->disableSAPIEmitter()->build('test');

    CASSMiddlewareTestCase::$app = $app;
}