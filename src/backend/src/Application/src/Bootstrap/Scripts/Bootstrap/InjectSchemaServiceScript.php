<?php
namespace Application\Bootstrap\Scripts\Bootstrap;

use Application\Bootstrap\AppBuilder;
use Application\Bootstrap\Scripts\BootstrapScript;
use Application\REST\Request\Params\SchemaParams;
use Application\REST\Service\SchemaService;

class InjectSchemaServiceScript implements BootstrapScript
{
    public function __invoke(AppBuilder $appBuilder)
    {
        SchemaParams::injectSchemaService($appBuilder->getContainer()->get(SchemaService::class));
    }
}