<?php
namespace PostAttachment\Service;

interface AttachmentTypeDetector
{
    public static function detect(string $tmpFile);
}