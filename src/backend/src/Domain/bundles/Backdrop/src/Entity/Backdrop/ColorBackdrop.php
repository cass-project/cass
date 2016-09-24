<?php
namespace CASS\Domain\Bundles\Backdrop\Entity\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Colors\Entity\Palette;

final class ColorBackdrop implements Backdrop
{
    const TYPE_ID = 'color';

    /** @var Palette */
    private $palette;

    public function __construct(Palette $palette)
    {
        $this->palette = $palette;
    }

    public function getType(): string
    {
        return self::TYPE_ID;
    }

    public function getPalette(): Palette
    {
        return $this->palette;
    }

    public function toJSON(): array
    {
        return [
            'type' => $this->getType(),
            'metadata' => [
                'palette' => $this->palette->toJSON(),
            ]
        ];
    }

}