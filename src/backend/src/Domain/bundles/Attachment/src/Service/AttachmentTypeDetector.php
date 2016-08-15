<?php
namespace Domain\Attachment\Service;

interface AttachmentTypeDetector
{
    public static function detect(string $tmpFile);
}