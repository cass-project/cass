<?php
namespace CASS\Domain\Bundles\Attachment\LinkMetadata\Types;

use CASS\Domain\Bundles\Attachment\LinkMetadata\LinkMetadata;
use CASS\Domain\Bundles\Attachment\LinkMetadata\Properties\HasPreview;

final class WebmLinkMetadata implements LinkMetadata, HasPreview
{
    const VERSION = 2;
    const RESOURCE_TYPE = 'webm';

    /** @var string */
    private $url;

    /** @var string */
    private $type;

    /** @var string */
    private $previewStoragePath;

    /** @var string */
    private $previewPublicPath;

    public function __construct(
        string $url,
        string $type
    ) {
        $this->url = $url;
        $this->type = $type;
    }

    public function getTitle(): string
    {
        return basename($this->url);
    }

    public function getDescription(): string
    {
        return '';
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

    public function setPreview(string $storage, string $public)
    {
        $this->previewStoragePath = $storage;
        $this->previewPublicPath = $public;
    }

    public function getPreviewStoragePath(): string
    {
        return $this->previewStoragePath;
    }

    public function getPreviewPublicPath(): string
    {
        return $this->previewPublicPath;
    }

    public function toJSON(): array
    {
        return [
            'type' => $this->type,
            'preview' => [
                'public' => $this->previewPublicPath,
                'storage' => $this->previewStoragePath,
            ]
        ];
    }
}