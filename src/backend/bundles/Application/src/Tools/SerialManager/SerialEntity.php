<?php
namespace Application\Tools\SerialManager;

interface SerialEntity
{
    public function getPosition(): int;
    public function setPosition(int $position);
    public function incrementPosition();
}