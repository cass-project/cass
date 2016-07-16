<?php
namespace Domain\IM\Query\Source;

use Domain\IM\Exception\Query\UnknownSourceException;
use Domain\IM\Query\Source\CommunitySource\CommunitySource;
use Domain\IM\Query\Source\ProfileSource\ProfileSource;

final class SourceFactory
{
    public function createSource(string $code, int $sourceId, int $targetId): Source
    {
        switch($code) {
            default:
                throw new UnknownSourceException(sprintf('Unknown source `%s`', $code));

            case ProfileSource::getCode():
                return new ProfileSource($sourceId, $targetId);

            case CommunitySource::getCode():
                return new CommunitySource($sourceId);
        }
    }
}