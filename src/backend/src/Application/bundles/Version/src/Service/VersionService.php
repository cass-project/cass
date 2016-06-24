<?php
namespace Application\Version\Service;

final class VersionService
{
    /** @var string */
    private $current;

    public function __construct(string $current)
    {
        $this->current = $current;
    }

    public function getCurrentVersion(): string
    {
        return $this->current;
    }
}