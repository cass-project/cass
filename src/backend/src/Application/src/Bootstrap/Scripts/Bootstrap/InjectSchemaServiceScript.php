<?php
namespace CASS\Application\Bootstrap\Scripts\Bootstrap;

use CASS\Application\Bootstrap\AppBuilder;
use CASS\Application\Bootstrap\Scripts\BootstrapScript;
use CASS\Application\REST\Request\Params\SchemaParams;
use CASS\Application\REST\Service\SchemaService;

class InjectSchemaServiceScript implements BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder)
    {
        SchemaParams::injectSchemaService($appBuilder->getContainer()->get(SchemaService::class));
    }
}