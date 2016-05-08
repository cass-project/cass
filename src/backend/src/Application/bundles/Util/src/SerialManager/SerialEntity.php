<?php
namespace Application\Util\SerialManager;

interface SerialEntity
{
    public function getPosition(): int;
    public function setPosition(int $position);
    public function incrementPosition();
}