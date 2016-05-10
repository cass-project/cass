<?php
namespace Application\PHPUnit\TestCase;

use Application\Doctrine2\Service\TransactionService;
use Application\PHPUnit\Fixture;
use Application\PHPUnit\RESTRequest\RESTRequest;
use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\SchemaService;
use Doctrine\ORM\EntityManager;
use PHPUnit_Framework_TestCase;
use Zend\Diactoros\Response;
use Application\PHPUnit\RESTRequest\Result;
use Zend\Expressive\Application;
use DI\Container;

class ExpectId {}
class ExpectString {}

/**
 * @backupGlobals disabled
 */
abstract class MiddlewareTestCase extends PHPUnit_Framework_TestCase
{
    /** @var Application */
    public static $app;

    /** @var Result */
    public static $currentResult;

    /**
     * Возвращает ссылку на текущее приложение
     * @return Application
     */
    protected function app(): Application {
        return self::$app;
    }

    /**
     * Возвращает ссылку на контейнер текущего приложения
     * Используйте для получение сервисов/репозиторие/etc
     * @return Container
     */
    protected function container(): Container {
        return self::$app->getContainer();
    }

    /**
     * Фикстуры
     * Возвращает массив фикстур, которые применяются к каждому юнит-тесту
     *
     * Массив должен быть пустым, либо содержать набор объектов классов,
     *  имплементирующие интерфейс Application\PHPUnit\Fixture
     *
     * Каждая фикстура содержит в себе статическую переменную, в которой хранятся объект/записи, созданные ей
     *
     * Примеры фикстур:
     *     - Domain\Account\Tests\Fixtures\DemoAccountFixture - тестовый аккаунт
     *      - Domain\Profile\Tests\Fixtures\DemoProfileFixture - тестовый профиль аккаунта
     *     - Domain\Theme\Tests\Fixtures\SampleThemesFixture - тестовые тематики
     *
     * @return array
     */
    protected abstract function getFixtures(): array;

    /**
     * Поднимает указанную фикстуру
     * @param Fixture $fixture
     * @return MiddlewareTestCase
     */
    protected function upFixture(Fixture $fixture): self {
        $app = $this->app();
        $em = $this->container()->get(EntityManager::class);
        $fixture->up($app, $em);

        return $this;
    }

    /**
     * Создает HTTP REST запрос
     *
     * 1. Установите параметры запроса с помощью set-методов и, если необходимо, задайте авторизацию:
     *
     *      $this->request('PUT', '/post/create')
     *          ->auth(DemoAccountFixture::getAccount()->getAPIKey())
     *          ->setParameters(['content' => 'someMessage'])
     *      ;
     *
     * 2. Выполните запрос:
     *
     *      $this->request('PUT', '/post/create')
     *          ->auth(DemoAccountFixture::getAccount()->getAPIKey())
     *          ->setParameters(['content' => 'someMessage'])
     *  +       ->execute()
     *      ;
     *
     * Проверьте на наличие нужного статуса и соответствие ответа определенному эталону:
     *
     *      $this->request('PUT', '/post/create')
     *          ->auth(DemoAccountFixture::getAccount()->getAPIKey())
     *          ->setParameters(['content' => 'someMessage'])
     *          ->execute()
     *   +      ->expectStatusCode(200)
     *   +      ->expectJSONContentType() // Проверяет Content-Type == application/json
     *   +      ->expectJSONBody([
     *   +          'success' => true,
     *   +          'entity' => [
     *   +              'id' => $this->expectId() // используйте этот метод, когда ожидаются автогенерируемые данные
     *   +              'content' => 'someMessage'
     *   +          ]
     *   +      ])
     *      ;
     * @param string $method HTTP-метод
     * @param string $uri URI
     * @return RESTRequest
     */
    protected function request(string $method, string $uri): RESTRequest
    {
        return new RESTRequest($this, $method, $uri);
    }

    /**
     * При выполнении каждого юнит-теста происходят следующие действия:
     *
     *  1. Стартует транзакция
     *  2. Применяются фикстуры
     *  3. Инжектится SchemaService в SchemaParams
     *
     * @throws \DI\NotFoundException
     */
    protected function setUp() {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->beginTransaction();

        $app = $this->app();
        $em = $this->container()->get(EntityManager::class);

        array_map(function(Fixture $fixture) use ($app, $em) {
            $this->upFixture($fixture);
        }, $this->getFixtures());

        SchemaParams::injectSchemaService($app->getContainer()->get(SchemaService::class));
    }

    /**
     * После завершения каждого юнит-теста происходит роллбак транзакции
     *
     * @throws \DI\NotFoundException
     */
    protected function tearDown() {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->rollback();
    }

    /* =============== */

    /**
     * Выводит в консоль содержимое текущего ответа
     */
    protected function dump(): self {
        var_dump("");
        var_dump("===== DUMP START =====");
        var_dump(sprintf('STATUS CODE: %s', self::$currentResult->getHttpResponse()->getStatusCode()));
        var_dump("CONTENT: ");
        print_r(self::$currentResult->getContent());
        var_dump("===== DUMP END =====");

        return $this;
    }

    /**
     * Проверка HTTP-кода
     * @param int $statusCode
     * @return MiddlewareTestCase
     */
    protected function expectStatusCode(int $statusCode): self {
        $this->assertEquals($statusCode, self::$currentResult->getHttpResponse()->getStatusCode());

        return $this;
    }

    /**
     * Используйте в качестве плейсхолдера для автогенерируемых значение в эталонных массивах (для expectJSONBody)
     * @return ExpectId
     */
    protected function expectId(): ExpectId {
        return new ExpectId();
    }

    protected function expectString(): ExpectString {
        return new ExpectString();
    }

    protected function expectJSONContentType(): self {
        $this->assertEquals('application/json', self::$currentResult->getHttpResponse()->getHeader('Content-Type')[0]);

        return $this;
    }

    /**
     * Ожидается ошибка 403 Не авторизован
     * @return MiddlewareTestCase
     */
    protected function expectAuthError(): self {
        return $this->expectJSONContentType()
            ->expectStatusCode(403)
            ->expectJSONError();
    }

    protected function expectJSONError(): self {
        $result = self::$currentResult->getContent();

        $this->assertTrue(is_array($result));
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('error', $result);
        $this->assertEquals(false, $result['success']);
        $this->assertTrue(is_string($result['error']));

        return $this;
    }

    /**
     * Проверяет результат на соответствие эталонному значению
     * @see expectId
     * @param array $expectedJSONBody
     * @return MiddlewareTestCase
     */
    protected function expectJSONBody(array $expectedJSONBody): self {
        $this->recursiveAssertEquals($expectedJSONBody, self::$currentResult->getContent());

        return $this;
    }

    private function recursiveAssertEquals(array $expected, array $actual) {
        foreach($expected as $key=>$value) {
            $this->assertArrayHasKey($key, $actual);

            if($value instanceof ExpectId) {
                $this->assertTrue(is_int($actual[$key]));
                $this->assertGreaterThan(0, $actual[$key]);
            }else if($value instanceof ExpectString) {
                $this->assertTrue(is_string($actual[$key]));
            }else if(is_array($value)) {
                $this->recursiveAssertEquals($value, $actual[$key]);
            }else{
                $this->assertEquals($expected[$key], $actual[$key]);
            }
        }
    }
}