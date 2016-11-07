<?php
namespace CASS\Application\Bundles\PHPUnit\TestCase;

use CASS\Application\Bundles\Doctrine2\Service\TransactionService;
use CASS\Application\Bundles\PHPUnit\TestCase\Expectations\ExpectImageCollection;
use Doctrine\ORM\EntityManager;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use MongoDB\Database;
use ZEA2\Platform\Bundles\PHPUnit\Fixture;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\MiddlewareTestCase;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\SchemaService;

abstract class CASSMiddlewareTestCase extends MiddlewareTestCase
{
    /**
     * Фикстуры
     * Возвращает массив фикстур, которые применяются к каждому юнит-тесту
     *
     * Массив должен быть пустым, либо содержать набор объектов классов,
     *  имплементирующие интерфейс ZEA2\Platform\Bundles\PHPUnit\Fixture
     *
     * Каждая фикстура содержит в себе статическую переменную, в которой хранятся объект/записи, созданные ей
     *
     * Примеры фикстур:
     *     - CASS\Domain\Bundles\Account\Tests\Fixtures\DemoAccountFixture - тестовый аккаунт
     *      - CASS\Domain\Bundles\Profile\Tests\Fixtures\DemoProfileFixture - тестовый профиль аккаунта
     *     - CASS\Domain\Bundles\Theme\Tests\Fixtures\SampleThemesFixture - тестовые тематики
     *
     * @return array
     */
    protected abstract function getFixtures(): array;
    
    /**
     * При выполнении каждого юнит-теста происходят следующие действия:
     *
     *  1. Стартует транзакция
     *  2. Применяются фикстуры
     *  3. Инжектится SchemaService в SchemaParams
     *
     * @throws \DI\NotFoundException
     */
    protected function setUp()
    {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->beginTransaction();

        $currentAccountService = $this->container()->get(CurrentAccountService::class); /** @var CurrentAccountService $currentAccountService */
        $currentAccountService->emptyToken();

        $app = $this->app();
        $em = $this->container()->get(EntityManager::class);

        array_map(function(Fixture $fixture) use ($app, $em) {
            $this->upFixture($fixture);
        }, $this->getFixtures());

        SchemaParams::injectSchemaService($app->getContainer()->get(SchemaService::class));
    }

    /**
     * После завершения каждого юнит-теста происходит роллбак транзакции и удаляются MongoDB-записи
     *
     * @throws \DI\NotFoundException
     */
    protected function tearDown()
    {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->rollback();

        /** @var Database $mongoDB */
        $mongoDB = $this->container()->get(Database::class);
        $mongoDB->drop();

        /** @var CurrentAccountService $currentAccountService */
        $currentAccountService = $this->container()->get(CurrentAccountService::class);
        $currentAccountService->emptyToken();
    }

    /**
     * Поднимает указанную фикстуру
     * @param Fixture $fixture
     * @return CASSMiddlewareTestCase
     */
    protected function upFixture(Fixture $fixture): self
    {
        $app = $this->app();
        $em = $this->container()->get(EntityManager::class);
        $fixture->up($app, $em);

        return $this;
    }

    protected function upFixtures(array $fixtures): self
    {
        foreach($fixtures as $fixture) {
            $this->upFixture($fixture);
        }

        return $this;
    }

    public function expectImageCollection(): ExpectImageCollection
    {
        return new  ExpectImageCollection();
    }
}