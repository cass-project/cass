<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

use ZEA2\Platform\Markers\IdEntity\IdEntity;
use ZEA2\Platform\Markers\SIDEntity\SIDEntity;

interface BackdropEntityAware extends IdEntity, SIDEntity
{
    public function setBackdrop(Backdrop $backdrop);
    public function getBackdrop(): Backdrop;
}