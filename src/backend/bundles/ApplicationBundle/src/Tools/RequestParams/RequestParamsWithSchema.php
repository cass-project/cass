<?php
/**
 * Created by PhpStorm.
 * User: dborisenko
 * Date: 25.02.16
 * Time: 16:29
 */
namespace Application\Tools\RequestParams;

use Application\Service\JSONSchema;
use Application\Service\SchemaService;
use Psr\Http\Message\ServerRequestInterface;

class InvalidJSONSchema extends \Exception {}

abstract class RequestParamsWithSchema implements RequestParams
{
    /** @var SchemaService */
    private static $schemaService;

    /** @var ServerRequestInterface $request */
    private $request;

    /** @var object */
    private $data;

    public static function injectSchemaService(SchemaService $schemaService)
    {
        self::$schemaService = $schemaService;
    }

    public static function getSchemaService(): SchemaService
    {
        return self::$schemaService;
    }

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->data = json_decode($request->getBody());

        $this->validateSchema();
        $this->setup();
    }

    protected function createParam($source, $key, $isRequired = false)
    {
        return new Param($source, $key, $isRequired);
    }

    private function validateSchema()
    {
        $data = $this->data;

        $schema = $this->getValidatorSchema();
        $validator = $schema->validate($data);

        if (!($validator->isValid())) {
            throw new InvalidJSONSchema('Invalid JSON');
        }
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    public function getData()
    {
        return $this->data;
    }

    protected abstract function setup();

    protected abstract function getValidatorSchema(): JSONSchema;
}