<?php
namespace Domain\Avatar\Service;

use Application\Exception\NotImplementedException;
use Application\Util\GenerateRandomString;
use Domain\Avatar\Exception\InvalidRatioException;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Service\Context\AvatarStrategy;
use League\Flysystem\Filesystem;
use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\ImageWorkshop;

final class AvatarService
{
    const GENERATE_FILENAME_LENGTH = 8;

    public function makeImages(AvatarStrategy $strategy, ImageWorkshopLayer $source): ImageCollection
    {
        $collection = new ImageCollection();

        $sizes = $strategy->getSizes();
        sort($sizes);

        foreach($sizes as $size) {
            if((! $collection->hasImage($size)) && ($source->getWidth() >= $size)) {
                $collection->attachImage((string) $size, $this->createImage($strategy, $source, $size));
            }
        }

        $collection->attachImage('original', $this->createImage($strategy, $source, $source->getWidth()));

        if($collection->hasImage($strategy->getDefaultSize())) {
            $collection->attachImage('default', clone $collection->getImage((string) $strategy->getDefaultSize()));
        }else{
            $collection->attachImage('original', clone $collection->getImage('original'));
        }

        return $collection;
    }

    public function defaultImage(AvatarStrategy $strategy)
    {
        $this->destroyImages($strategy);

        $strategy->getEntity()->exportImages($this->makeImages($strategy, ImageWorkshop::initFromPath($strategy->getDefaultImage()->getStoragePath())));
    }

    public function uploadImage(AvatarStrategy $strategy, UploadImageParameters $parameters)
    {
        $this->destroyImages($strategy);

        $start = $parameters->getPointStart();
        $end = $parameters->getPointEnd();

        $source = ImageWorkshop::initFromPath($parameters->getTmpFile());
        $source->crop(ImageWorkshopLayer::UNIT_PIXEL, $end->getX() - $start->getX(), $end->getY() - $start->getY(), $start->getX(), $start->getY());

        $strategy->getEntity()->exportImages($this->makeImages($strategy, $source));
    }

    public function destroyImages(AvatarStrategy $strategy)
    {
        $fs = $strategy->getFilesystem();
        $dir = (string) $strategy->getEntityId();

        if($fs->has($dir)) {
            $fs->deleteDir($dir);
        }
    }

    public function generateImage(AvatarStrategy $strategy) {
        throw new NotImplementedException;
    }

    private function createImage(AvatarStrategy $strategy, ImageWorkshopLayer $source, int $size): Image
    {
        $ratio = array_filter(explode(':', $strategy->getRatio()), function($input) {
            return is_int($input);
        });

        if(count($ratio) !== 2) {
            throw new InvalidRatioException(sprintf('Invalid ratio `%s`', $strategy->getRatio()));
        }

        $width = $size;
        $height = ($size / $ratio[0]) * $ratio[1];

        $image = clone $source;
        $image->resize(ImageWorkshopLayer::UNIT_PIXEL, $width, $height);
        $image->save(
            $dir = $this->touchDir($strategy->getFilesystem(), $strategy->getEntityId(), $size),
            $file = sprintf('%s.png', GenerateRandomString::gen(self::GENERATE_FILENAME_LENGTH))
        );

        return new Image(
            "{$dir}/{$file}",
            sprintf("%s/%s/%s", $strategy->getPublicPath(), $strategy->getEntityId(), $size)
        );
    }

    private function touchDir(Filesystem $fs, $entityId, $imageId): string
    {
        $resultPath = sprintf('%s/%s', $entityId, $imageId);

        if(! $fs->has((string) $entityId)) {
            $fs->createDir((string) $entityId);
        }

        if(! $fs->has($resultPath)) {
            $fs->createDir($resultPath);
        }

        return $resultPath;
    }
}