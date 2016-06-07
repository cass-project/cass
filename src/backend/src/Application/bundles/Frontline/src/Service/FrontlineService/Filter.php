<?php
namespace Application\Frontline\Service\FrontlineService;

interface Filter
{
    public function filter(array $scripts): array;
}