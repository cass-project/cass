<?php
namespace Application\Swagger;

use Application\Bundle\GenericBundle;

class SwaggerBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}