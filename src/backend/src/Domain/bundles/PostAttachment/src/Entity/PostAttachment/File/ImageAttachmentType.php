<?php
namespace Domain\PostAttachment\Entity\PostAttachment\File;

use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Entity\PostAttachment\FileAttachmentType;
use Domain\PostAttachment\Service\AttachmentTypeDetector;
use Domain\PostAttachment\Service\AttachmentTypeExtension;

class ImageAttachmentType implements FileAttachmentType, AttachmentTypeDetector, AttachmentTypeExtension
{
    const MAX_FILE_SIZE_BYTES = 1024 * 1024 * 32 /* mb */;

    public function getCode() {
        return 'image';
    }

    public function getMinFileSizeBytes() {
        return 1;
    }

    public function getMaxFileSizeBytes() {
        return self::MAX_FILE_SIZE_BYTES;
    }

    public function extend(PostAttachment $postAttachment): array {
        $file = $postAttachment->getAttachment()['file']['storage_path'];
        
        list($width, $height) = getimagesize($file);

        return [
            'image' => [
                'size' => [
                    'width' => $width,
                    'height' => $height
                ]
            ]
        ];
    }

    public static function detect(string $tmpFile) {
        $image = getimagesize($tmpFile);

        return $image !== false;
    }
}