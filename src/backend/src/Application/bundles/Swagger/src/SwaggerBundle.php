<?php
namespace Application\Swagger;

use Application\Common\Bootstrap\Bundle\GenericBundle;

class SwaggerBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}