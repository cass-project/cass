<?php
namespace CASS\Domain\Bundles\IM\Query\Source\ProfileSource;

use CASS\Domain\Bundles\IM\Exception\Query\InvalidSourceParamsException;
use CASS\Domain\Bundles\IM\Query\Source\Source;

final class ProfileSource implements Source
{
    const SOURCE_CODE = 'profile';

    /** @var int */
    private $sourceProfileId;

    /** @var int */
    private $targetProfileId;

    public function __construct(int $sourceProfileId, int $targetProfileId)
    {
        if($sourceProfileId <= 0 || $targetProfileId <= 0) {
            throw new InvalidSourceParamsException('Invalid source/targer profile Id');
        }

        $this->sourceProfileId = $sourceProfileId;
        $this->targetProfileId = $targetProfileId;
    }

    public static function getCode(): string
    {
        return self::SOURCE_CODE;
    }

    public function getSourceId(): int
    {
        return $this->sourceProfileId;
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