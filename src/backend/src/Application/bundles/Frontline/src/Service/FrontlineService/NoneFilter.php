<?php
namespace Application\Frontline\Service\FrontlineService;

class NoneFilter implements Filter
{
    public function filter(array $scripts): array {
        return $scripts;
    }
}