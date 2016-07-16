<?php
namespace Domain\IM\Exception\Query\Options\MarkAsReadOption;

use Domain\IM\Exception\Query\Options\Option;

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

    public function unpack(array $params)
    {
        $this->messageIds = array_filter($params, function($input) {
            return is_int($input);
        });
    }

    public function getMessageIds(): array
    {
        return $this->messageIds;
    }
}