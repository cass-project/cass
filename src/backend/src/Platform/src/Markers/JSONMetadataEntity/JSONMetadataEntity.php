<?php
namespace ZEA2\Platform\Markers\JSONMetadataEntity;

interface JSONMetadataEntity
{
    public function replaceMetadata(array $metadata);
    public function &getMetadata(): array;
    public function getMetadataVersion(): string;
}