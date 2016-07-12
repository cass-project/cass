<?php
namespace Domain\PostAttachment\LinkMetadata;

use Application\Util\JSONSerializable;

interface LinkMetadata extends JSONSerializable
{
    public function getURL(): string;
    public function getResourceType(): string;
    public function toJSON(): array;
}