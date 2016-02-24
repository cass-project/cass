<?php
namespace Data\Repository;

use Data\Entity\Host;
use Doctrine\ORM\EntityRepository;

class HostRepository extends EntityRepository
{
    const DEFAULT_REPOSITORY_ID = 1;

    public function getDefaultHost(): Host {
        return $this->find(self::DEFAULT_REPOSITORY_ID);
    }
}