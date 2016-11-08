<?php
namespace CASS\Domain\Bundles\Profile\Entity\Card\Access;

use CASS\Util\JSONSerializable;

final class ProfileCardAccess implements JSONSerializable
{
    const ACCESS_PUBLIC = 'public';
    const ACCESS_PROTECTED = 'protected';
    const ACCESS_PRIVATE = 'private';

    /** @var string */
    private $key;

    /** @var string */
    private $accessLevel;

    public function __construct(string $key, string $accessLevel)
    {
        $this->key = $key;
        $this->setAccessLevel($accessLevel);
    }

    public function toJSON(): array
    {
        return [
            'key' => $this->getKey(),
            'level' => $this->getAccessLevel(),
        ];
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getAccessLevel(): string
    {
        return $this->accessLevel;
    }

    public function setAccessLevel(string $accessLevel): self
    {
        if(! in_array($accessLevel, [self::ACCESS_PRIVATE, self::ACCESS_PROTECTED, self::ACCESS_PUBLIC])) {
            throw new \Exception(sprintf('Unknown access level `%s`', $accessLevel));
        }

        $this->accessLevel = $accessLevel;

        return $this;
    }
}