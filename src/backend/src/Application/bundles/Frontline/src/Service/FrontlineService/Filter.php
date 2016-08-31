<?php
namespace CASS\Application\Bundles\Frontline\Service\FrontlineService;

interface Filter
{
    public function filter(array $scripts): array;
}