<?php
namespace CASS\Domain\Profile\Entity\Profile\Gender;

final class GenderMale extends Gender
{
    const INT_CODE = 0;
    const STRING_CODE = 'male';

    public function getIntCode(): int
    {
        return self::INT_CODE;
    }

    public function getStringCode(): string
    {
        return self::STRING_CODE;
    }
}