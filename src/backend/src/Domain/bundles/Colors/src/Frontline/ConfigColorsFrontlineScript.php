<?php
namespace Domain\Colors\Frontline;

use Application\Frontline\FrontlineScript;
use Domain\Colors\Entity\Palette;
use Domain\Colors\Service\ColorsService;

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