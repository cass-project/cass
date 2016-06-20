<?php
namespace Domain\Profile\Entity\Profile\Gender;

use Application\Util\JSONSerializable;
use Domain\Profile\Exception\UnknownGenderException;

abstract class Gender implements JSONSerializable
{
    abstract public function getIntCode(): int;
    abstract public function getStringCode(): string ;

    public static function createFromStringCode(string $code): Gender
    {
        switch(strtolower($code)) {
            default:
                throw new UnknownGenderException(sprintf('Gender with string code `%s` is unknown', $code));

            case GenderNotSpecified::STRING_CODE: return new GenderNotSpecified();
            case GenderMale::STRING_CODE: return new GenderMale();
            case GenderFemale::STRING_CODE: return new GenderFemale();
        }
    }

    public static function createFromIntCode(int $code): Gender
    {
        switch($code) {
            default:
                throw new UnknownGenderException(sprintf('Gender with int code `%d` is unknown', $code));

            case GenderNotSpecified::INT_CODE: return new GenderNotSpecified();
            case GenderMale::INT_CODE: return new GenderMale();
            case GenderFemale::INT_CODE: return new GenderFemale();
        }
    }

    public function toJSON(): array
    {
        return [
            'int' => $this->getIntCode(),
            'string' => $this->getStringCode(),
        ];
    }
}