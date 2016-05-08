<?php
namespace Domain\PostAttachment\Service;

interface AttachmentTypeDetector
{
    public static function detect(string $tmpFile);
}