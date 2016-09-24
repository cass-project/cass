<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\SIDEntity\SIDEntity;

interface BackdropEntityAware extends IdEntity, SIDEntity
{
    public function setBackdrop(Backdrop $backdrop);
    public function getBackdrop(): Backdrop;
}