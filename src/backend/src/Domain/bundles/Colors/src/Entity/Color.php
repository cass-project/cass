<?php
namespace Domain\Colors\Entity;

use Application\Util\JSONSerializable;

class Color implements JSONSerializable
{
    const REGEX_COLOR = '/\#[0-9abcdefABCDEF]{6}/';

    /** @var string */
    private $code;

    /** @var string */
    private $hexCode;

    public function __construct(string $code, string $hexCode) {
        if(! preg_match(self::REGEX_COLOR, $hexCode)) {
            throw new \InvalidArgumentException('Invalid hexCode');
        }

        if(strlen($code) < 3) {
            throw new \Exception('Invalid code');
        }

        $this->code = $code;
        $this->hexCode = $hexCode;
    }

    public function toJSON(): array {
        return [
            'code' => $this->code,
            'hexCode' => $this->hexCode
        ];
    }

    public function getCode(): string {
        return $this->code;
    }

    public function getHexCode(): string {
        return $this->hexCode;
    }

    public function  toRGB():array {
        $hex = str_replace("#", "", $this->hexCode);

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        $rgb = array($r, $g, $b);
        return $rgb;
    }

    public function getName():string
    {
        preg_match("#([a-z-]*)\.#i", $this->code, $m);
        return $m[1];
    }

}