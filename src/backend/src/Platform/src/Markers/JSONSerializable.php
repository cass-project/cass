<?php
namespace ZEA2\Platform\Markers;

interface JSONSerializable
{
    public function toJSON(): array;
}