<?php
namespace CASS\Domain\Bundles\Backdrop\Entity\Backdrop;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;

final class NoneBackdrop implements Backdrop
{
    const TYPE_ID = 'none';

    public function getType(): string
    {
        return self::TYPE_ID;
    }

    public function toJSON(): array
    {
        return [
            'type' => $this->getType(),
            'metadata' => [],
        ];
    }
}