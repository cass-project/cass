<?php
namespace CASS\Domain\IM\Query\Source\CommunitySource;

use CASS\Domain\IM\Query\Source\Source;

final class CommunitySource implements Source
{
    const SOURCE_CODE = 'community';

    /** @var int */
    private $communityId;

    public function __construct(int $communityId)
    {
        $this->communityId = $communityId;
    }

    public static function getCode(): string
    {
        return self::SOURCE_CODE;
    }

    public function getMongoDBCollectionName(): string
    {
        return sprintf('im_community_%s', $this->communityId);
    }

    public function getSourceId(): int
    {
        return $this->communityId;
    }
}