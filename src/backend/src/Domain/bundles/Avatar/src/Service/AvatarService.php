<?php
namespace Domain\Avatar\Service;

use Application\Exception\NotImplementedException;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Service\Context\AvatarStrategy;

final class AvatarService
{
    public function setImages(AvatarStrategy $strategy, ImageCollection $images)
    {
        // TODO: auto-generated 16x16, 32x32, ...

        $strategy->getEntity()->exportImages($images);
    }

    public function defaultImage(AvatarStrategy $strategy)
    {
        $this->setImages($strategy, (new ImageCollection())->attachImage(
            'default', $strategy->getDefaultImage()
        ));
    }

    public function uploadImage(AvatarStrategy $strategy, UploadImageParameters $parameters)
    {

    }

    /**
     * Используйте defaultImage либо generateImage (предпочт.)
     * @deprecated
     */
    public function destroyImage(AvatarStrategy $strategy) {
        $this->defaultImage($strategy);
    }

    public function generateImage(AvatarStrategy $strategy) {
        throw new NotImplementedException;
    }
}