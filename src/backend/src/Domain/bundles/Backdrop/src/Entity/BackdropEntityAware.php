<?php
namespace CASS\Domain\Bundles\Backdrop\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;

interface BackdropEntityAware extends IdEntity
{
    public function exportBackdrop(Backdrop $backdrop);
    public function extractBackdrop(): Backdrop;
    public function getBackdropPublicPath(): string;
}