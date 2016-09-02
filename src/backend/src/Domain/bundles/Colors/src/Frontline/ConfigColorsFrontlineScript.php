<?php
namespace CASS\Domain\Bundles\Colors\Frontline;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Domain\Bundles\Colors\Entity\Palette;
use CASS\Domain\Bundles\Colors\Service\ColorsService;

class ConfigColorsFrontlineScript implements FrontlineScript
{
    /** @var ColorsService */
    private $colorService;

    public function __construct(ColorsService $colorService) {
        $this->colorService = $colorService;
    }


    public function tags(): array {
        return [
            FrontlineScript::TAG_GLOBAL
        ];
    }

    public function __invoke(): array {
        return [
            'config' => [
                'palettes' => array_map(function(Palette $palette) {
                    return $palette->toJSON();
                }, $this->colorService->getPalettes())
            ]
        ];
    }
}