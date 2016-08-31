<?php
namespace {
    require __DIR__ . '/../vendor/autoload.php';
}

namespace PhpUnitBootstrap
{
    use CASS\Application\ApplicationBundle;
    use CASS\Application\Bootstrap\AppBuilder;
    use CASS\Application\PHPUnit\TestCase\MiddlewareTestCase;
    use CASS\Project\ProjectBundle;
    use Domain\DomainBundle;

    $app = (new AppBuilder([
        new ApplicationBundle(),
        new DomainBundle(),
        new ProjectBundle(),
    ]))->disableSAPIEmitter()->build('test');

    MiddlewareTestCase::$app = $app;
}