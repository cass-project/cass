<?php
namespace Domain\Feedback\FeedbackType\Types;

final class FTCommonQuestion extends AbstractFeedbackType
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

    public function getTitle(): string
    {
        return 'Общие вопросы';
    }

    public function getDescription(): string
    {
        return 'Если вы не нашли в списке подходящую категорию или вам просто лень искать, то выберите эту категорию';
    }
}