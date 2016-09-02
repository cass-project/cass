<?php
namespace CASS\Domain\Bundles\Attachment\LinkMetadata;

use CASS\Util\JSONSerializable;

interface LinkMetadata extends JSONSerializable
{
    public function getURL(): string;

    public function getResourceType(): string;

    public function toJSON(): array;
}