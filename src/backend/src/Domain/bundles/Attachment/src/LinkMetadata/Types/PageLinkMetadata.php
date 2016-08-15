<?php
namespace Domain\Attachment\LinkMetadata\Types;

use Domain\Attachment\LinkMetadata\LinkMetadata;

final class PageLinkMetadata implements LinkMetadata
{
    const RESOURCE_TYPE = 'page';

    /** @var string */
    private $url;

    /** @var array */
    private $openGraph;

    public function __construct(string $url, array $openGraph)
    {
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
        ];
    }
}