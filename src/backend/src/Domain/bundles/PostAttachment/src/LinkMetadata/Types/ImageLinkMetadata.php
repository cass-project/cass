<?php
namespace Domain\PostAttachment\LinkMetadata\Types;

use Domain\PostAttachment\LinkMetadata\LinkMetadata;

final class ImageLinkMetadata implements LinkMetadata
{
    const RESOURCE_TYPE = 'image';

    /** @var string */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
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
        return [];
    }
}