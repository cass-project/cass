<?php
namespace CASS\Application\Service;

final class HostService
{
    /** @var string */
    private $currentHost;

    public function __construct(string $currentHost)
    {
        $this->currentHost = $currentHost;
    }

    public function getCurrentHost(): string
    {
        return $this->currentHost;
    }
}