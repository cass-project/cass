<?php
namespace CASS\Domain\Bundles\Attachment\Source;

use CASS\Util\JSONSerializable;

interface Source extends JSONSerializable
{
    public function getCode(): string;
}