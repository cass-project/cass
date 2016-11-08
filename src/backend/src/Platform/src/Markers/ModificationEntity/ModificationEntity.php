<?php
namespace ZEA2\Platform\Markers\ModificationEntity;

interface ModificationEntity
{
    public function getDateCreatedAt(): \DateTime;
    public function getLastUpdatedOn(): \DateTime;
}