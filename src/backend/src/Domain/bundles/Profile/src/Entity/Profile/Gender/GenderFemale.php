<?php
namespace Domain\Profile\Entity\Profile\Gender;

final class GenderFemale extends Gender
{
    const INT_CODE = 1;
    const STRING_CODE = 'female';

    public function getIntCode(): int
    {
        return self::INT_CODE;
    }

    public function getStringCode(): string
    {
        return self::STRING_CODE;
    }
}