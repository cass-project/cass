<?php
namespace CASS\Application\Bundles\Frontline;

interface FrontlineBundleInjectable
{
    public function getFrontlineScripts(): array;
}