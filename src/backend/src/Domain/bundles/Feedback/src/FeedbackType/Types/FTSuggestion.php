<?php
namespace Domain\Feedback\FeedbackType\Types;

use Domain\Feedback\FeedbackType\FeedbackType;

final class FTSuggestion implements FeedbackType
{
    const INT_CODE = 3;
    const STRING_CODE = 'suggestion';

    public function getIntCode(): int
    {
        return self::INT_CODE;
    }

    public function getStringCode(): string
    {
        return self::STRING_CODE;
    }
}