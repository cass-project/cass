<?php
namespace Domain\PostAttachment\Entity\PostAttachment\File;

use Domain\PostAttachment\Entity\PostAttachment\FileAttachmentType;
use Domain\PostAttachment\Service\AttachmentTypeDetector;

class WebmAttachmentType implements FileAttachmentType, AttachmentTypeDetector
{
    public function getCode() {
        return 'webm';
    }

    public static function detect(string $tmpFile) {
        $finfoMime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmpFile);

        return in_array($finfoMime, ['audio/webm', 'video/webm']);
    }

    public function getMinFileSizeBytes() {
        return 1;
    }

    public function getMaxFileSizeBytes() {
        return 64 * 1024 * 1024;
    }
}