<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

use CASS\Util\JSONSerializable;

final class Backdrop implements JSONSerializable
{
    /** @var string */
    private $type;

    /** @var string */
    private $storage;

    /** @var string */
    private $public;

    public function __construct(string $type, string $storage, string $public)
    {
        $this->type = $type;
        $this->storage = $storage;
        $this->public = $public;
    }

    public function toJSON(): array
    {
        return [
            'type' => $this->getType(),
            'public' => $this->getPublic(),
            'storage' => $this->getStorage(),
        ];
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getStorage(): string
    {
        return $this->storage;
    }

    public function getPublic(): string
    {
        return $this->public;
    }
}