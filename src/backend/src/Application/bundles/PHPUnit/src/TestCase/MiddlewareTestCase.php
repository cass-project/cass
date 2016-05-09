<?php
namespace Application\PHPUnit\TestCase;

use Application\Doctrine2\Service\TransactionService;
use Application\PHPUnit\Fixture;
use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\SchemaService;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Domain\Auth\Service\CurrentAccountService;
use PHPUnit_Framework_TestCase;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;
use Zend\Expressive\Application;
use Zend\Stratigility\Http\Response as HttpResponse;

/**
 * @backupGlobals disabled
 */
abstract class MiddlewareTestCase extends PHPUnit_Framework_TestCase
{
    /** @var Application */
    public static $app;

    /** @var array */
    protected $output = [];

    protected function app(): Application {
        return self::$app;
    }

    protected function container(): Container {
        return self::$app->getContainer();
    }

    protected function execute(ServerRequest $request): Response {
        $response = new Response();
        $this->app()->run($request, $response);

        return $response;
    }

    protected function setUp() {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->beginTransaction();

        $app = $this->app();
        $em = $this->container()->get(EntityManager::class);

        array_map(function(Fixture $fixture) use ($app, $em) {
            $fixture->up($app, $em);
        }, $this->getFixtures());

        SchemaParams::injectSchemaService($app->getContainer()->get(SchemaService::class));
    }

    protected function tearDown() {
        $transactionService = $this->container()->get(TransactionService::class); /** @var TransactionService $transactionService */
        $transactionService->rollback();
    }

    protected abstract function getFixtures(): array;
    
    protected function executeJSONRequest(
        string $uri,
        string $method = 'GET',
        array $jsonRequest = [],
        array $params = []
    ): HttpResponse {
        $app = $this->app();
        $params = array_merge([
            'uri' => $uri,
            'method' => $method,
            'jsonRequest' => $jsonRequest,
            'uploadedFiles' => [],
            'headers' => [],
            'x-api-key' => false,
            'server' => [],
            'cookies' => [],
            'query' => []
        ], $params);

        /** @var CurrentAccountService $currentAccountService */
        $currentAccountService = $app->getContainer()->get(CurrentAccountService::class);
        $currentAccountService->emptyToken();

        $request = (new ServerRequest())
            ->withMethod($params['method'])
            ->withUri(new Uri($params['uri']))
        ;

        if($params['x-api-key']) {
            $request = $request->withHeader('X-Api-Key', (string) $params['x-api-key']);
        }

        if($params['jsonRequest']) {
            $request = $request->withParsedBody(json_decode(json_encode($params['jsonRequest'])));
        }

        ob_start();
        $response = $app($request, new Response);
        $app->getEmitter()->emit($response);
        $this->output = json_decode(ob_get_clean(), true);

        return $response;
    }
}