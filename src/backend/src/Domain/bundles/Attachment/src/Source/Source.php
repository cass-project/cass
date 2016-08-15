<?php
namespace Domain\Attachment\Source;

use Application\Util\JSONSerializable;

interface Source extends JSONSerializable
{
    public function getCode(): string;
}