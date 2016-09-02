<?php
namespace CASS\Domain\Feedback\FeedbackType\Types;

final class FTThemeRequest extends AbstractFeedbackType
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

    public function getTitle(): string
    {
        return 'Тематики';
    }

    public function getDescription(): string
    {
        return 'Отправляйте сюда запросы на добавление и/или реструктиризацию дерева тематик';
    }
}