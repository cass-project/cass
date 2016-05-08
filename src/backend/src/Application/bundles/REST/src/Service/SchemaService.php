<?php
use Application\Service\BundleService;
use JsonSchema\Validator;
use Symfony\Component\Yaml\Yaml;

class NoAPIDocsAvailableException extends \Exception {}
class SchemaFileNotExists extends \Exception {}
class CachedSchemaNotFound extends \Exception {}

interface SchemaCache {
    public function generateCacheToken(string $bundle, string $path);
    public function putSchemaToCache(string $token, JSONSchema $schema);
    public function hasCachedSchema(string $token): bool;
    public function getCachedSchema(string $token): JSONSchema;
    public function reset();
}

class JSONSchema {
    /** @var array */
    private $definition;

    /** @var Validator */
    private $validator;

    public function __construct($definition)
    {
        $this->definition = $definition;
        $this->validator = new Validator();
    }

    public function getDefinition()
    {
        return $this->definition;
    }

    public function getValidator(): Validator
    {
        return $this->validator;
    }

    public function validate($data): Validator
    {
        $this->validator->check($data, $this->definition);

        return $this->validator;
    }
}

class SchemaService
{
    /** @var SchemaCache */
    private $cache;

    /** @var BundleService */
    private $bundleService;

    /**
     * SchemaService constructor.
     * @param BundleService $bundleService
     */
    public function __construct(BundleService $bundleService)
    {
        $this->bundleService = $bundleService;
        $this->cache = new class implements SchemaCache {
            /** @var JSONSchema[] */
            private $schemas = [];

            public function generateCacheToken(string $bundle, string $path)
            {
                return sprintf('bundle_%s_path_%s', $bundle, $path);
            }

            public function putSchemaToCache(string $token, JSONSchema $schema)
            {
                $this->schemas[$token] = $schema;
            }

            public function hasCachedSchema(string $token): bool
            {
                return isset($this->schemas[$token]);
            }

            public function getCachedSchema(string $token): JSONSchema
            {
                if(!($this->hasCachedSchema($token))) {
                    throw new CachedSchemaNotFound(sprintf('No schema available with token `%s`', $token));
                }

                return $this->schemas[$token];
            }

            public function reset()
            {
                $this->schemas = [];
            }
        };
    }

    public function getSchema($bundleName, $path) {
        $cache = $this->cache;
        $token = $cache->generateCacheToken($bundleName, $path);

        if(!($cache->hasCachedSchema($token))) {
            $cache->putSchemaToCache($token, $this->fetchSchema($bundleName, $path));
        }

        return $cache->getCachedSchema($token);
    }

    private function fetchSchema($bundleName, $path): JSONSchema {
        $bundle = $this->bundleService->getBundleByName($bundleName);

        if(!($bundle->hasAPIDocsDir())) {
            throw new NoAPIDocsAvailableException(sprintf('No API docs available for bundle `%s`', $bundle->getName()));
        }

        $apiFile = "{$bundle->getAPIDocsDir()}/{$path}";

        if(!(file_exists($apiFile))) {
            throw new SchemaFileNotExists(sprintf('Schema file `%s` not found', $apiFile));
        }

        $yaml = Yaml::parse(file_get_contents($apiFile));
        $yaml = array_pop($yaml);
        $yaml = json_decode(json_encode($yaml));

        return new JSONSchema($yaml);
    }
}