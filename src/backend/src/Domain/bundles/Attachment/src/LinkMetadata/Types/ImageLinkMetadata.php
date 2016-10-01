<?php
namespace CASS\Domain\Bundles\Attachment\LinkMetadata\Types;

use CASS\Domain\Bundles\Attachment\LinkMetadata\LinkMetadata;

final class ImageLinkMetadata implements LinkMetadata
{
    const VERSION = 1;
    const RESOURCE_TYPE = 'image';

    /** @var string */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
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
            'preview' => $this->getURL(),
        ];
    }
}