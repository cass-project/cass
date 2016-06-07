<?php
namespace Domain\Colors\Repository;

use Domain\Colors\Entity\Palette;

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
            'red' => ['900', '50'],
            'pink' => ['900', '50'],
            'purple' => ['900', '50'],
            'deep-purple' => ['900', '50'],
            'indigo' => ['900', '50'],
            'blue' => ['900', '50'],
            'light-blue' => ['900', '50'],
            'cyan' => ['900', '50'],
            'teal' => ['900', '50'],
            'green' => ['900', '50'],
            'light-green' => ['900', '50'],
            'lime' => ['900', '50'],
            'yellow' => ['900', '50'],
            'amber' => ['900', '50'],
            'orange' => ['900', '50'],
            'deep-orange' => ['900', '50'],
            'brown' => ['900', '50'],
            'grey' => ['900', '50'],
            'blue-grey' => ['900', '50'],
        ];

        foreach($definitions as $code => $definition) {
            $palettes[$code] = new Palette(
                $code,
                $this->colorsRepository->getColor($code, $definition[0]),
                $this->colorsRepository->getColor($code, $definition[1])
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