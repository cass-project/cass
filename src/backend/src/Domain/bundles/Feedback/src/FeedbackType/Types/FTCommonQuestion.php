<?php
namespace Domain\Feedback\FeedbackType\Types;

use Domain\Feedback\FeedbackType\FeedbackType;

final class FTCommonQuestion implements FeedbackType
{
    const INT_CODE = 1;
    const STRING_CODE = 'common-question';

    public function getIntCode(): int
    {
        return self::INT_CODE;
    }

    public function getStringCode(): string
    {
        return self::STRING_CODE;
    }
}