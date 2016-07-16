<?php
namespace Domain\IM\Source;

final class ProfileSource implements Source
{
    const SOURCE_CODE = 'profile';

    /** @var int */
    private $sourceProfileId;

    /** @var int */
    private $targetProfileId;

    public function __construct(int $sourceProfileId, int $targetProfileId)
    {
        $this->sourceProfileId = $sourceProfileId;
        $this->targetProfileId = $targetProfileId;
    }

    public static function getCode(): string
    {
        return self::SOURCE_CODE;
    }

    public function getMongoDBCollectionName(): string
    {
        return sprintf(
            'im_profile_%s_%s',
            min($this->sourceProfileId, $this->targetProfileId),
            min($this->sourceProfileId, $this->targetProfileId)
        );
    }

    public function getSourceProfileId(): int
    {
        return $this->sourceProfileId;
    }

    public function getTargetProfileId(): int
    {
        return $this->targetProfileId;
    }
}