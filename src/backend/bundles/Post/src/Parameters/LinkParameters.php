<?php
namespace Post\Parameters;

class LinkParameters
{
    /** @var string */
    private $url;

    /** @var array */
    private $metadata;

    public function __construct(string $url, array $metadata) {
        $this->url = $url;
        $this->metadata = $metadata;
    }

    public function getUrl(): string {
        return $this->url;
    }

    public function getMetadata(): array {
        return $this->metadata;
    }
}