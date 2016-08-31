<?php
namespace CASS\Application\Bundles\Version\Service;

final class VersionService
{
    /** @var string */
    private $current;

    /** @var string[] */
    private $blacklist;

    public function __construct(string $current, array $frontendSPABlacklist)
    {
        $this->current = $current;
        $this->blacklist = $frontendSPABlacklist;
    }

    public function getCurrentVersion(): string
    {
        return $this->current;
    }

    public function getBlacklistedFrontendSPAVersions(): array
    {
        return $this->blacklist;
    }
}