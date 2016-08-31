<?php
namespace CASS\Application\Frontline\Service\FrontlineService;

interface Filter
{
    public function filter(array $scripts): array;
}