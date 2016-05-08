<?php
namespace Application\Util;

interface JSONSerializable
{
    public function toJSON(): array;
}