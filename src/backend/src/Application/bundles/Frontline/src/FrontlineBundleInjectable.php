<?php
namespace CASS\Application\Frontline;

interface FrontlineBundleInjectable
{
    public function getFrontlineScripts(): array;
}