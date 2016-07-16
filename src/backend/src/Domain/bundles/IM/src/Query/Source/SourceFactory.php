<?php
namespace Domain\IM\Query\Source;

use Domain\IM\Exception\Query\UnknownSourceException;
use Domain\IM\Query\Source\CommunitySource\CommunitySource;
use Domain\IM\Query\Source\ProfileSource\ProfileSource;

final class SourceFactory
{
    public function createSource(string $code, array $params): Source
    {
        switch($code) {
            default:
                throw new UnknownSourceException(sprintf('Unknown source `%s`', $code));

            case ProfileSource::getCode():
                return ProfileSource::createFromParams($params);

            case CommunitySource::getCode():
                return CommunitySource::createFromParams($params);
        }
    }
}