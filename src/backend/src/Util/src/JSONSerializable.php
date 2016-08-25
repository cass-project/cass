<?php
namespace CASS\Util;

interface JSONSerializable
{
    public function toJSON(): array;
}