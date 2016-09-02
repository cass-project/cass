<?php
namespace CASS\Domain\Bundles\Community\Scripts;

use CASS\Util\Scripts\AvatarUploadScript;

class CommunityImageUploadScript extends AvatarUploadScript
{
    const MIN_IMAGE_WIDTH = 64;
    const MIN_IMAGE_HEIGHT = 64;
    const MAX_IMAGE_WIDTH = 256;
    const MAX_IMAGE_HEIGHT = 256;

    protected function aspectRatio() {
        return "1:1";
    }

    protected function getMinImageWidth(): int {
        return self::MIN_IMAGE_WIDTH;
    }

    protected function getMaxImageWidth(): int {
        return self::MAX_IMAGE_WIDTH;
    }

    protected function getMinImageHeight(): int {
        return self::MIN_IMAGE_HEIGHT;
    }

    protected function getMaxImageHeight(): int {
        return self::MAX_IMAGE_HEIGHT;
    }
}