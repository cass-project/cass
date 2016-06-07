<?php
namespace Domain\Colors\Entity;

use Application\Util\JSONSerializable;

class Palette implements JSONSerializable
{
    /** @var string */
    private $code;

    /** @var Color */
    private $background;

    /** @var Color */
    private $foreground;

    public function __construct(string $code, Color $background, Color $foreground) {
        $this->code = $code;
        $this->background = $background;
        $this->foreground = $foreground;
    }

    public function toJSON(): array {
        return [
            'code' => $this->code,
            'background' => $this->background->toJSON(),
            'foreground' => $this->foreground->toJSON()
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
}