<?php
namespace ZEA2\Platform\Markers\IdEntity;

interface IdEntity
{
    public function isPersisted(): bool;
    public function getId(): int;
    public function getIdNoFall();
}