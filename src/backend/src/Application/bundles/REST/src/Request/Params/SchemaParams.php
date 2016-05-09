<?php
namespace Application\REST\Request\Params;

use Application\REST\Service\JSONSchema;
use Psr\Http\Message\ServerRequestInterface;
use Application\REST\Service\SchemaService;

class InvalidJSONSchema extends \Exception {}

abstract class SchemaParams implements RequestParamsInterface
{
    /** @var SchemaService */
    private static $schemaService;

    /** @var object */
    private $data;

    /** @var ServerRequestInterface */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;

        if($request->getParsedBody()) {
            $this->data = $request->getParsedBody();
        }else{
            $this->data = json_decode($request->getBody());
        }

        $this->validateSchema();
    }

    private function validateSchema()
    {
        $data = $this->data;

        $schema = $this->getSchema();
        $validator = $schema->validate($data);

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