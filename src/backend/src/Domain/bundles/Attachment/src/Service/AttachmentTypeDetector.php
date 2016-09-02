<?php
namespace CASS\Domain\Bundles\Attachment\Service;

interface AttachmentTypeDetector
{
    public static function detect(string $tmpFile);
}