<?php
namespace CASS\Domain\Bundles\Community\Formatter;

use CASS\Domain\Bundles\Community\Entity\Community;

final class CommunityFormatter
{
    public function formatMany(array $communities): array
    {
        return array_map(function(Community $community) {
            return $community->toJSON();
        }, $communities);
    }

    public function formatOne(Community $community): array
    {
        return $community->toJSON();
    }
}