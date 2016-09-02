<?php
namespace CASS\Domain\Attachment\Entity\Metadata\File;

use CASS\Domain\Attachment\Entity\Attachment;
use CASS\Domain\Attachment\Entity\Metadata\FileAttachmentType;
use CASS\Domain\Attachment\Service\AttachmentTypeDetector;
use CASS\Domain\Attachment\Service\AttachmentTypeExtension;
use League\Flysystem\FilesystemInterface;

class ImageAttachmentType implements FileAttachmentType, AttachmentTypeDetector, AttachmentTypeExtension
{
    const MAX_FILE_SIZE_BYTES = 1024*1024*32; /* mb */

    public function setFileSystem(FilesystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function getCode()
    {
        return 'image';
    }

    public function getMinFileSizeBytes()
    {
        return 1;
    }

    public function getMaxFileSizeBytes()
    {
        return self::MAX_FILE_SIZE_BYTES;
    }

    public function extend(Attachment $attachment): array
    {
        return [];
    }

    public static function detect(string $tmpFile)
    {
        $image = getimagesize($tmpFile);

        return $image !== false;
    }
}