<?php
namespace CASS\Domain\Post\Parameters;

class LinkParameters
{
    /** @var string */
    private $url;
    
    /** @var string */
    private $resource;

    /** @var array */
    private $metadata;

    public function __construct(string $url, string $resource, array $metadata) {
        $this->url = $url;
        $this->resource = $resource;
        $this->metadata = $metadata;
    }

    public function getUrl(): string {
        return $this->url;
    }
    
    public function getResource(): string {
        return $this->resource;
    }

    public function getMetadata(): array {
        return $this->metadata;
    }
}