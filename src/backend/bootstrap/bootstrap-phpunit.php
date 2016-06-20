<?php
namespace {
    require __DIR__ . '/../vendor/autoload.php';
}

namespace PhpUnitBootstrap {

    use Application\PHPUnit\TestCase\MiddlewareTestCase;

    $app = (new \Application\Bootstrap\AppBuilder([
        new \Application\ApplicationBundle(),
        new \Domain\DomainBundle()
    ]))->disableSAPIEmitter()->build();

    MiddlewareTestCase::$app = $app;
}