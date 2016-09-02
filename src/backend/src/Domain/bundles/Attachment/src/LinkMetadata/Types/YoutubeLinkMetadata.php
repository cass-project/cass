<?php
namespace CASS\Domain\Attachment\LinkMetadata\Types;

use CASS\Domain\Attachment\LinkMetadata\LinkMetadata;

final class YoutubeLinkMetadata implements LinkMetadata
{
    const RESOURCE_TYPE = 'youtube';

    /** @var string */
    private $url;

    /** @var array */
    private $openGraph;

    /** @var string */
    private $youTubeId;

    public function __construct(string $url, array $openGraph, string $youTubeId)
    {
        $this->youTubeId = $youTubeId;
        $this->url = $url;
        $this->openGraph = $openGraph;
    }

    public function getURL(): string
    {
        return $this->url;
    }

    public function getResourceType(): string
    {
        return self::RESOURCE_TYPE;
    }

    public function toJSON(): array
    {
        return [
            'og' => $this->openGraph,
            'youtubeId' => $this->youTubeId,
        ];
    }
}