<?php
namespace CASS\Domain\Attachment\LinkMetadata\Types;

use CASS\Domain\Attachment\LinkMetadata\LinkMetadata;

final class UnknownLinkMetadata implements LinkMetadata
{
    const RESOURCE_TYPE = 'unknown';

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
        return [
            'og' => [
                'basic' => [
                    'title' => '',
                    'description' => '',
                    'url' => $this->getURL(),
                ],
            ],
        ];
    }
}