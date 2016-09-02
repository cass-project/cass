<?php
namespace CASS\Domain\Bundles\IM\Query\Source;

use CASS\Domain\Bundles\IM\Exception\Query\UnknownSourceException;
use CASS\Domain\Bundles\IM\Query\Source\CommunitySource\CommunitySource;
use CASS\Domain\Bundles\IM\Query\Source\ProfileSource\ProfileSource;

final class SourceFactory
{
    public function createSource(string $code, int $sourceId, int $targetId): Source
    {
        switch($code) {
            default:
                throw new UnknownSourceException(sprintf('Unknown source `%s`', $code));

            case ProfileSource::getCode():
                return new ProfileSource($targetId, $sourceId);

            case CommunitySource::getCode():
                return new CommunitySource($sourceId);
        }
    }
}