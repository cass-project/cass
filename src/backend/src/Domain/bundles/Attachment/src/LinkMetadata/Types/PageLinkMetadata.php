<?php
namespace CASS\Domain\Bundles\Attachment\LinkMetadata\Types;

use CASS\Domain\Bundles\Attachment\LinkMetadata\LinkMetadata;

final class PageLinkMetadata implements LinkMetadata
{
    const RESOURCE_TYPE = 'page';
    const VERSION = 1;

    /** @var string */
    private $url;

    /** @var array */
    private $openGraph;

    public function __construct(string $url, array $openGraph)
    {
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
        ];
    }
}