<?php
namespace CASS\Domain\Bundles\Attachment\Entity\Metadata\File;

use CASS\Domain\Bundles\Attachment\Entity\Metadata\FileAttachmentType;
use CASS\Domain\Bundles\Attachment\Service\AttachmentTypeDetector;

class WebmAttachmentType implements FileAttachmentType, AttachmentTypeDetector
{
    public function getCode()
    {
        return 'webm';
    }

    public static function detect(string $tmpFile)
    {
        $fInfoMIME = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmpFile);

        return in_array($fInfoMIME, ['audio/webm', 'video/webm']);
    }

    public function getMinFileSizeBytes()
    {
        return 1;
    }

    public function getMaxFileSizeBytes()
    {
        return 64*1024*1024;
    }
}