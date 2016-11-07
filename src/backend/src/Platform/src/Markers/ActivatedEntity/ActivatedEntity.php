<?php
namespace ZEA2\Platform\Markers\ActivatedEntity;

interface ActivatedEntity
{
    public function activate();
    public function deactivate();
    public function isActivated(): bool;
}