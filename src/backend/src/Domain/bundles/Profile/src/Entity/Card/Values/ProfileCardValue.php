<?php
namespace CASS\Domain\Bundles\Profile\Entity\Card\Values;

use CASS\Util\JSONSerializable;

final class ProfileCardValue implements JSONSerializable
{
    /** @var string */
    private $key;

    /** @var mixed */
    private $value;

    public function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function toJSON(): array
    {
        return [
            'key' => $this->getKey(),
            'value' => $this->getValue(),
        ];
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}