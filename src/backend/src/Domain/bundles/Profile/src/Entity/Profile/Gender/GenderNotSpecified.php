<?php
namespace CASS\Domain\Profile\Entity\Profile\Gender;

final class GenderNotSpecified extends Gender
{
    const INT_CODE = -1;
    const STRING_CODE = 'not-specified';

    public function getIntCode(): int
    {
        return self::INT_CODE;
    }

    public function getStringCode(): string
    {
        return self::STRING_CODE;
    }
}