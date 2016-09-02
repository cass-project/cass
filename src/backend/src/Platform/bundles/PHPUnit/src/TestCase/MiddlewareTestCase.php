<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase;

use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\RESTRequest;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\Expectation;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectationParams;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\Traits\AllExpectationsTrait;
use PHPUnit_Framework_TestCase;
use Zend\Diactoros\Response;
use ZEA2\Platform\Bundles\PHPUnit\RESTRequest\Result;
use Zend\Expressive\Application;
use DI\Container;

/**
 * @backupGlobals disabled
 */
abstract class MiddlewareTestCase extends PHPUnit_Framework_TestCase
{
    use AllExpectationsTrait;

    const NOT_FOUND_ID = 9999999;

    /** @var Application */
    public static $app;

    /** @var Result */
    public static $currentResult;

    /**
     * Возвращает ссылку на текущее приложение
     * @return Application
     */
    protected function app(): Application
    {
        return self::$app;
    }

    /**
     * Возвращает ссылку на контейнер текущего приложения
     * Используйте для получение сервисов/репозиторие/etc
     * @return Container
     */
    protected function container(): Container
    {
        return self::$app->getContainer();
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
     * @param array $queryParams
     * @return RESTRequest
     */
    protected final function request(string $method, string $uri, array $queryParams = null): RESTRequest
    {
        return new RESTRequest($this, $method, $uri, $queryParams);
    }

    /**
     * Возвращает последний возвращенный результат
     * @return Result
     */
    protected function getLastResult(): Result
    {
        return self::$currentResult;
    }

    protected function getParsedLastResult(): array
    {
        return self::$currentResult->getContent();
    }


    /* =============== */

    /**
     * Выводит в консоль содержимое текущего ответа
     */
    protected function dump(): self
    {
        var_dump("");
        var_dump("===== DUMP START =====");
        var_dump(sprintf('STATUS CODE: %s', self::$currentResult->getHttpResponse()->getStatusCode()));
        var_dump("CONTENT: ");
        print_r(self::$currentResult->getContent());
        var_dump("===== DUMP END =====");

        return $this;
    }

    protected function dumpError(): self
    {
        $result = self::$currentResult->getContent();

        if(isset($result['error'])) {
            var_dump("");
            var_dump("===== ERROR START =====");
            var_dump(sprintf('STATUS CODE: %s', self::$currentResult->getHttpResponse()->getStatusCode()));
            var_dump(sprintf("ERROR: ", $result['error']));
            var_dump("===== ERROR END =====");
        }else{
            throw new \Exception('No error');
        }
    }

    /**
     * Проверка HTTP-кода
     * @param int $statusCode
     * @return MiddlewareTestCase
     */
    protected function expectStatusCode(int $statusCode): self
    {
        $this->assertEquals($statusCode, self::$currentResult->getHttpResponse()->getStatusCode());

        return $this;
    }

    protected function expectJSONContentType(): self
    {
        $this->assertEquals('application/json', self::$currentResult->getHttpResponse()->getHeader('Content-Type')[0]);

        return $this;
    }

    protected function expect(Callable $callback): self
    {
        $callback(self::$currentResult->getContent());

        return $this;
    }

    protected function with(Callable $callback): self
    { /* alias */
        return $this->expect($callback);
    }

    /**
     * Ожидается ошибка 403 Не авторизован
     * @return MiddlewareTestCase
     */
    protected function expectAuthError(): self
    {
        return $this->expectJSONContentType()
            ->expectStatusCode(403)
            ->expectJSONError()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString(),
            ]);
    }

    /**
     * Ожидается ошибка 404 Не найдено
     * @return MiddlewareTestCase
     */
    protected function expectNotFoundError(): self
    {
        return $this->expectJSONContentType()
            ->expectStatusCode(404)
            ->expectJSONError()
            ->expectJSONBody([
                'success' => false,
                'error' => $this->expectString(),
            ]);
    }

    protected function expectJSONError(): self
    {
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
    protected function expectJSONBody(array $expectedJSONBody): self
    {
        $this->recursiveAssertEquals($expectedJSONBody, self::$currentResult->getContent());

        return $this;
    }

    protected function fetch(Callable $callback)
    {
        return $callback(self::$currentResult->getContent());
    }

    public function recursiveAssertEquals(array $expected, array $actual, string $level = '- ')
    {
        foreach($expected as $key => $value) {
            if(is_string($value) || is_int($value) || is_bool($value)) {
                echo sprintf("\n%sASSERT: %s == %s", $level, $key, (string) (
                is_object($actual[$key])
                    ? "#OBJECT"
                    : var_export($actual[$key], true)
                ));
            }

            if($value instanceof Expectation) {
                $value->expect(new ExpectationParams(
                    $this,
                    $level,
                    $actual,
                    $expected,
                    $key,
                    $value
                ));
            }else if(is_array($value)) {
                $this->recursiveAssertEquals($value, $actual[$key], $level . '- ');
            }else if(is_object($value) && ($value instanceof \Closure)) {
                $value($actual[$key]);
            }else{
                $this->assertEquals($expected[$key], $actual[$key]);
            }
        }
    }
}