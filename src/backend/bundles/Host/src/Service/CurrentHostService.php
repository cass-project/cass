<?php
namespace Host\Service;

use Data\Entity\Host;
use Data\Repository\HostRepository;

class CurrentHostService
{
    /** @var HostRepository */
    private $hostRepository;

    public function __construct(HostRepository $hostRepository)
    {
        $this->hostRepository = $hostRepository;
    }

    public function getCurrentHost(): Host {
        return $this->hostRepository->getDefaultHost();
    }
}