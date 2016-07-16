<?php
namespace Domain\IM\Query\Options\MarkAsReadOption;

use Domain\IM\Query\Options\Option;

final class MarkAsReadOption implements Option
{
    const OPTION_CODE = 'markAsRead';

    /** @var int[] */
    private $messageIds = [];

    public function __construct(array $messageIds)
    {
        $this->messageIds = $messageIds;
    }

    public static function getCode(): string
    {
        return self::OPTION_CODE;
    }

    public static function createOptionFromParams(array $params): Option
    {
        return new self($params['message_ids'] ?? []);
    }

    public function getMessageIds(): array
    {
        return $this->messageIds;
    }
}