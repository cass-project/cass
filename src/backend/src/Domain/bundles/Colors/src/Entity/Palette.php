<?php
namespace Domain\Colors\Entity;

use CASS\Util\JSONSerializable;

class Palette implements JSONSerializable
{
    /** @var string */
    private $code;

    /** @var Color */
    private $background;

    /** @var Color */
    private $foreground;

    /** @var Color */
    private $border;

    public function __construct(string $code, Color $background, Color $foreground, Color $border) {
        $this->code = $code;
        $this->background = $background;
        $this->foreground = $foreground;
        $this->border = $border;
    }

    public function toJSON(): array {
        return [
            'code' => $this->code,
            'background' => $this->background->toJSON(),
            'foreground' => $this->foreground->toJSON(),
            'border' => $this->border->toJSON(),
        ];
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getBackground(): Color {
        return $this->background;
    }

    public function getForeground(): Color {
        return $this->foreground;
    }

    public function getBorder(): Color {
        return $this->border;
    }
}