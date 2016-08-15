<?php
namespace Domain\Attachment\LinkMetadata;

use Application\Util\JSONSerializable;

interface LinkMetadata extends JSONSerializable
{
    public function getURL(): string;

    public function getResourceType(): string;

    public function toJSON(): array;
}