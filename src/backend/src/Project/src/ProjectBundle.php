<?php
namespace CASS\Project;

use Application\Bundle\GenericBundle;

final class ProjectBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}