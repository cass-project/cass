<?php
namespace CASS\Domain\Feedback\FeedbackType\Types;

final class FTSuggestion extends AbstractFeedbackType
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

    public function getTitle(): string
    {
        return 'Предложения';
    }

    public function getDescription(): string
    {
        return 'Ваши пожелания и предложения';
    }
}