<?php
namespace Domain\Feedback\FeedbackType\Types;

use Domain\Feedback\FeedbackType\FeedbackType;

final class FTThemeRequest implements FeedbackType
{
    const INT_CODE = 2;
    const STRING_CODE = 'theme-request';

    public function getIntCode(): int
    {
        return self::INT_CODE;
    }

    public function getStringCode(): string
    {
        return self::STRING_CODE;
    }
}