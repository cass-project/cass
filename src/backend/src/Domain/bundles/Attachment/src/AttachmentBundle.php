<?php
namespace Domain\Attachment;

use Application\Bundle\GenericBundle;

class AttachmentBundle extends GenericBundle
{
    public function getDir()
    {
        return __DIR__;
    }
}