<?php
namespace CASS\Application\REST\Request\Params;

use CASS\Application\REST\Service\JSONSchema;
use Psr\Http\Message\ServerRequestInterface;
use CASS\Application\REST\Service\SchemaService;

class InvalidJSONSchema extends \Exception {}

abstract class SchemaParams implements RequestParamsInterface
{
    /** @var SchemaService */
    private static $schemaService;

    /** @var array */
    private $data;

    /** @var ServerRequestInterface */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;

        if($request->getParsedBody()) {
            $this->data = json_decode(json_encode($request->getParsedBody()), true);
        }else{
            $this->data = json_decode($request->getBody(), true);
        }

        $this->validateSchema();
    }

    private function validateSchema()
    {
        $data = $this->getData();

        $schema = $this->getSchema();
        $validator = $schema->validate(json_decode(json_encode($data)));

        if (!($validator->isValid())) {
            throw new InvalidJSONSchema('Invalid JSON');
        }
    }

    public static function injectSchemaService(SchemaService $schemaService)
    {
        self::$schemaService = $schemaService;
    }

    public static function getSchemaService(): SchemaService
    {
        return self::$schemaService;
    }

    abstract protected function getSchema(): JSONSchema;

    protected function getData()
    {
        return $this->data;
    }

    protected function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}