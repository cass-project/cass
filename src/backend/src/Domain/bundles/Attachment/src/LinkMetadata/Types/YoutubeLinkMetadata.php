<?php
namespace CASS\Domain\Bundles\Attachment\LinkMetadata\Types;

use CASS\Domain\Bundles\Attachment\LinkMetadata\LinkMetadata;

final class YoutubeLinkMetadata implements LinkMetadata
{
    const VERSION = 1;
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

    public function getVersion(): int
    {
        return self::VERSION;
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