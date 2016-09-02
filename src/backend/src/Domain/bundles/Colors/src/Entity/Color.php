<?php
namespace CASS\Domain\Colors\Entity;

use CASS\Util\JSONSerializable;

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

    public function getName():string
    {
        preg_match('#([a-z-]*)\.#i', $this->code, $m);
        return $m[1];
    }
}