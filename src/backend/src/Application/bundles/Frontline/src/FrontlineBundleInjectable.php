<?php
namespace Application\Frontline;

interface FrontlineBundleInjectable
{
    public function getFrontlineScripts(): array;
}