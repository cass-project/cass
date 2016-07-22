<?php
namespace Application\PHPUnit\RESTRequest;

use Application\PHPUnit\TestCase\MiddlewareTestCase;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class RESTRequest
{
    /**
     * Юнит-тест, которому принадлежит реквест
     * @var MiddlewareTestCase
     */
    private $unitTest;

    /**
     * HTTP метод
     * @var string
     */
    private $method;

    /**
     * URL-адрес
     * Адрес задается без дополнительного префикса /backend/api
     * @var string
     */
    private $uri;

    /**
     * Параметры (JSON-body) запроса
     * @var array|null
     */
    private $parameters;

    /**
     * Параметры (QueryParams) запроса
     * @var array|null
     */
    private $queryParams;

    /**
     * Загружаемые/прикрепляемые файлы
     * Содержат массив из [name] => new UploadedFile(..)
     * @var array|null
     */
    private $uploadedFiles;

    /**
     * Дополнительные хидеры к запросу (Header => Value)
     * @var array|null
     */
    private $addedHeaders;

    /**
     * Если не NULL, то к запросу добавляется хидер Authorization
     * @var string|null
     */
    private $xApiKey;

    public function __construct(MiddlewareTestCase $unitTest, string $method, string $uri, array $queryParams = null)
    {
        $this->unitTest = $unitTest;
        $this->method = $method;
        $this->uri = $uri;
        $this->queryParams = $queryParams;
    }

    public function execute(): MiddlewareTestCase
    {
        $app = MiddlewareTestCase::$app;
        $request = (new ServerRequest())
            ->withMethod($this->method)
            ->withUri(new Uri($this->uri))
        ;

        if($this->parameters) {
            $request = $request->withParsedBody(json_decode(json_encode($this->parameters), true));
        }

        if($this->uploadedFiles) {
            $request = $request->withUploadedFiles($this->uploadedFiles);
        }

        if($this->addedHeaders) {
            foreach($this->addedHeaders as $header => $value) {
                $request = $request->withHeader($header, $value);
            }
        }

        if($this->queryParams) {
            $request = $request->withQueryParams($this->queryParams);
        }

        if($this->xApiKey) {
            $request = $request->withHeader('Authorization', $this->xApiKey);
        }

        ob_start();
        $response = $app($request, new Response());
        $app->getEmitter()->emit($response);
        $result = json_decode(ob_get_clean(), true);

        MiddlewareTestCase::$currentResult = new Result($request, $response, $result);

        return $this->unitTest;
    }

    public function auth(string $apiKey): self
    {
        $this->xApiKey = $apiKey;

        return $this;
    }

    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function setUploadedFiles(array $uploadedFiles): self
    {
        $this->uploadedFiles = $uploadedFiles;

        return $this;
    }

    public function setAddedHeaders(array $addedHeaders): self
    {
        $this->addedHeaders = $addedHeaders;

        return $this;
    }
}