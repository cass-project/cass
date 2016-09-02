<?php
namespace CASS\Domain\Attachment;

use CASS\Application\Bundle\GenericBundle;

class AttachmentBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}