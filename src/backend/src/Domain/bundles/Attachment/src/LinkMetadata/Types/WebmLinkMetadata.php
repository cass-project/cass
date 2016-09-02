<?php
namespace CASS\Domain\Bundles\Attachment\LinkMetadata\Types;

use CASS\Domain\Bundles\Attachment\LinkMetadata\LinkMetadata;

final class WebmLinkMetadata implements LinkMetadata
{
    const RESOURCE_TYPE = 'webm';

    /** @var string */
    private $url;

    /** @var string */
    private $type;

    public function __construct(string $url, string $contentType)
    {
        $this->url = $url;
        $this->type = $contentType;
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
            'type' => $this->type,
        ];
    }
}