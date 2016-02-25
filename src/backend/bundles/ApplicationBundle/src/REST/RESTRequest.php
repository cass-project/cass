<?php
namespace Application\REST;

use Application\Service\JSONSchema;
use Application\Service\SchemaService;
use Psr\Http\Message\ServerRequestInterface;

class InvalidRESTRequestException extends \Exception {}

abstract class RESTRequest
{
    /** @var SchemaService */
    private static $schemaService;

    /** @var ServerRequestInterface $request */
    private $request;

    /** @var object */
    private $data;

    public static function injectSchemaService(SchemaService $schemaService) {
        self::$schemaService = $schemaService;
    }

    public static function getSchemaService(): SchemaService {
        return self::$schemaService;
    }

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
        $this->data = json_decode($request->getBody());

        $this->validateSchema();
        $this->setup();
    }

    private function validateSchema() {
        $data = $this->data;

        $schema = $this->getValidatorSchema();
        $validator = $schema->validate($data);

        if(!($validator->isValid())) {
            throw new InvalidRESTRequestException('Invalid JSON');
        }
    }

    public function getData() {
        return $this->data;
    }

    protected abstract function setup();
    protected abstract function getValidatorSchema(): JSONSchema;
}