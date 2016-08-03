<?php
namespace {
    require __DIR__ . '/../vendor/autoload.php';
}

namespace PhpUnitBootstrap
{
    use Application\ApplicationBundle;
    use Application\Bootstrap\AppBuilder;
    use Application\PHPUnit\TestCase\MiddlewareTestCase;
    use CASS\Project\ProjectBundle;
    use Domain\DomainBundle;

    $app = (new AppBuilder([
        new ApplicationBundle(),
        new DomainBundle(),
        new ProjectBundle(),
    ]))->disableSAPIEmitter()->build('test');

    MiddlewareTestCase::$app = $app;
}