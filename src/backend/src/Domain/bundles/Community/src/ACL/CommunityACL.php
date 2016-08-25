<?php
namespace Domain\Community\ACL;

use CASS\Util\JSONSerializable;

class CommunityACL implements JSONSerializable
{
    /** @var bool */
    private $hasAdminAccess;

    public function __construct(bool $hasAdminAccess)
    {
        $this->hasAdminAccess = $hasAdminAccess;
    }

    public function toJSON(): array
    {
        return [
            'admin' => $this->hasAdminAccess()
        ];
    }

    public function hasAdminAccess(): bool
    {
        return $this->hasAdminAccess;
    }
}