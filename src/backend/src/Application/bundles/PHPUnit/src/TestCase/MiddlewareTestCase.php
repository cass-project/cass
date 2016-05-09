<?php
namespace Application\PHPUnit\TestCase;

use Application\Doctrine2\Service\TransactionService;
use Application\PHPUnit\Fixture;
use DI\Container;
use Doctrine\ORM\EntityManager;
use PHPUnit_Framework_TestCase;
use Zend\Expressive\Application;

/**
 * @backupGlobals disabled
 */
abstract class MiddlewareTestCase extends PHPUnit_Framework_TestCase
{
    /** @var Application */
    public static $app;

    protected function app(): Application {
        return self::$app;
    }

    protected function container(): Container {
        return self::$app->getContainer();
    }

    protected function setUp() {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->beginTransaction();

        $app = $this->app();
        $em = $this->container()->get(EntityManager::class);

        array_map(function(Fixture $fixture) use ($app, $em) {
            $fixture->up($app, $em);
        }, $this->getFixtures());
    }

    protected function tearDown() {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->rollback();
    }

    protected abstract function getFixtures(): array;
}