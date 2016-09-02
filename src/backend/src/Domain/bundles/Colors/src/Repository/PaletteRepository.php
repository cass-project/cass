<?php
namespace CASS\Domain\Bundles\Colors\Repository;

use CASS\Domain\Bundles\Colors\Entity\Palette;

class PaletteRepository
{
    /** @var ColorsRepository */
    private $colorsRepository;

    /** @var Palette[] */
    private $palettes;

    public function __construct(ColorsRepository $colorsRepository) {
        $this->colorsRepository = $colorsRepository;

        $palettes = [];
        $definitions = [
            'red' => ['500', '50', '900'],
            'pink' => ['500', '50', '900'],
            'purple' => ['500', '50', '900'],
            'deep-purple' => ['500', '50', '900'],
            'indigo' => ['500', '50', '900'],
            'blue' => ['500', '50', '900'],
            'light-blue' => ['500', '50', '900'],
            'cyan' => ['500', '50', '900'],
            'teal' => ['500', '50', '900'],
            'green' => ['500', '50', '900'],
            'light-green' => ['500', '50', '900'],
            'lime' => ['500', '50', '900'],
            'yellow' => ['500', '50', '900'],
            'amber' => ['500', '50', '900'],
            'orange' => ['500', '50', '900'],
            'deep-orange' => ['500', '50', '900'],
            'brown' => ['500', '50', '900'],
            'grey' => ['500', '50', '900'],
            'blue-grey' => ['500', '50', '900'],
        ];

        foreach($definitions as $code => $definition) {
            $palettes[$code] = new Palette(
                $code,
                $this->colorsRepository->getColor($code, $definition[0]),
                $this->colorsRepository->getColor($code, $definition[1]),
                $this->colorsRepository->getColor($code, $definition[2])
            );
        }

        $this->palettes = $palettes;
    }

    public function getPalettes(): array {
        return $this->palettes;
    }

    public function getPalette(string $code): Palette {
        return $this->palettes[$code];
    }
}