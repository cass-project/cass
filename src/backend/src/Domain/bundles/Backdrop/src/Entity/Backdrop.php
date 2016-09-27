<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

use CASS\Util\JSONSerializable;

interface Backdrop extends JSONSerializable
{
    public function getType(): string;
}