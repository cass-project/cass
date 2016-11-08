<?php
namespace ZEA2\Platform\Markers\SerialEntity;

interface SerialEntity
{
    public function getPosition(): int;
    public function setPosition(int $position);
    public function incrementPosition();
}