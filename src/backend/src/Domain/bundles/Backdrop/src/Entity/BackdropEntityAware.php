<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;

interface BackdropEntityAware extends IdEntity
{
    public function setBackdrop(Backdrop $backdrop);
    public function getBackdrop(): Backdrop;
}