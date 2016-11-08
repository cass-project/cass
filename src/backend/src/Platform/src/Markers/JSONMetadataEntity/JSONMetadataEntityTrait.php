<?php
namespace ZEA2\Platform\Markers\JSONMetadataEntity;

trait JSONMetadataEntityTrait
{
    /**
     * @Column(name="metadata", type="json_array")
     * @var array
     */
    private $metadata = [];

    public function replaceMetadata(array $metadata) {
        $this->metadata = $metadata;
    }

    public function &getMetadata(): array {
        if(! is_array($this->metadata)) {
            $this->metadata = [];
        }

        return $this->metadata;
    }
}