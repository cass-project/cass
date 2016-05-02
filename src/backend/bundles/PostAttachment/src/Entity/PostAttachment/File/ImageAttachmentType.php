<?php
namespace PostAttachment\Entity\PostAttachment\File;

use PostAttachment\Entity\PostAttachment;
use PostAttachment\Entity\PostAttachment\FileAttachmentType;
use PostAttachment\Service\AttachmentTypeDetector;
use PostAttachment\Service\AttachmentTypeExtension;

class ImageAttachmentType implements FileAttachmentType, AttachmentTypeDetector, AttachmentTypeExtension
{
    public function getCode() {
        return 'image';
    }

    public function getMinFileSizeBytes() {
        return 1;
    }

    public function getMaxFileSizeBytes() {
        return 1024 * 32 /* mb */;
    }

    public function extend(PostAttachment $postAttachment): array {
        $file = $postAttachment->getAttachment()['file']['storage'];
        
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