<?php
namespace Domain\Avatar\Service;

use Application\Util\GenerateRandomString;
use Domain\Avatar\Exception\InvalidCropException;
use Domain\Avatar\Exception\InvalidRatioException;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Strategy\AvatarStrategy;
use Intervention\Image\ImageManager;
use Intervention\Image\Image as ImageLayer;
use League\Flysystem\FilesystemInterface;

final class AvatarService
{
    const GENERATE_FILENAME_LENGTH = 8;

    /** @var ImageManager */
    private $imageManager;

    public function __construct(
        ImageManager $imageManager
    ) {
        $this->imageManager = $imageManager;
    }

    public function makeImages(AvatarStrategy $strategy, ImageLayer $source): ImageCollection
    {
        $collection = new ImageCollection();

        $sizes = $strategy->getSizes();
        sort($sizes);

        foreach($sizes as $size) {
            if((! $collection->hasImage($size)) && ($source->getWidth() >= $size)) {
                $collection->attachImage((string) $size, $this->createImage($strategy, $source, $collection->getUID(), $size));
            }
        }

        if($collection->hasImage($strategy->getDefaultSize())) {
            $collection->attachImage('default', clone $collection->getImage((string) $strategy->getDefaultSize()));
        }else{
            $collection->attachImage('original', clone $collection->getImage(min($sizes)));
        }

        return $collection;
    }

    public function defaultImage(AvatarStrategy $strategy)
    {
        $oldCollectionUID = null;

        if($strategy->getEntity()->hasImages()) {
            $oldCollectionUID = $strategy->getEntity()->getImages()->getUID();
        }

        $this->destroyImages($strategy);

        $source = $this->imageManager->make($strategy->getDefaultImage()->getStoragePath());
        $images = $this->makeImages($strategy, $source);

        $strategy->validate($source);
        $strategy->getEntity()->setImages($images);

        if($oldCollectionUID) {
            $strategy->getFilesystem()->deleteDir(sprintf('%s/%s', $strategy->getEntityId(), $oldCollectionUID));
        }
    }

    public function uploadImage(AvatarStrategy $strategy, UploadImageParameters $parameters)
    {
        $oldCollectionUID = null;

        if($strategy->getEntity()->hasImages()) {
            $oldCollectionUID = $strategy->getEntity()->getImages()->getUID();
        }
        
        $this->destroyImages($strategy);
        
        $start = $parameters->getPointStart();
        $end = $parameters->getPointEnd();

        $source = $this->imageManager->make($parameters->getTmpFile());

        if(($start->getX() > $end->getX()) || ($start->getY() > $end->getY())) {
            throw new InvalidCropException(sprintf('Invalid start/end points, got Point(%d, %d) – Point(%d, %d)',
                $start->getX(),
                $start->getY(),
                $end->getX(),
                $end->getY()
            ));
        }

        if(($source->getWidth() < $end->getX()) || ($source->getHeight() < $end->getY())) {
            throw new InvalidCropException(sprintf('Unable to crop with Point(%d, %d) – Point(%d, %d)',
                $start->getX(),
                $start->getY(),
                $end->getX(),
                $end->getY()
            ));
        }

        $source->crop($end->getX() - $start->getX(), $end->getY() - $start->getY(), $start->getX(), $start->getY());

        $strategy->validate($source);
        $strategy->getEntity()->setImages($this->makeImages($strategy, $source));

        if($oldCollectionUID) {
            $strategy->getFilesystem()->deleteDir(sprintf('%s/%s', $strategy->getEntityId(), $oldCollectionUID));
        }
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
        $this->defaultImage($strategy);
    }

    private function createImage(AvatarStrategy $strategy, ImageLayer $source, string $collectionUID, int $size): Image
    {
        $ratio = array_filter(explode(':', $strategy->getRatio()), function($input) {
            return is_numeric($input);
        });

        if(count($ratio) !== 2) {
            throw new InvalidRatioException(sprintf('Invalid ratio `%s`', $strategy->getRatio()));
        }

        $width = $size;
        $height = ($size / (int) $ratio[0]) * (int) $ratio[1];

        $image = clone $source;
        $image->resize($width, $height);

        $dir = $this->touchDir($strategy->getFilesystem(), $strategy->getEntityId(), $collectionUID, $size);
        $file = sprintf('%s.png', GenerateRandomString::gen(self::GENERATE_FILENAME_LENGTH));

        $strategy->getFilesystem()->write("{$dir}/{$file}", $image->encode('png'));

        return new Image(
            "{$dir}/{$file}",
            sprintf("%s/%s/%s/%s", $strategy->getPublicPath(), $strategy->getEntityId(), $size, $file)
        );
    }

    private function touchDir(FilesystemInterface $fs, string $entityId, string $collectionUID, string $imageId): string
    {
        $resultPath = sprintf('%s/%s/%s', $entityId, $collectionUID, $imageId);

        if(! $fs->has($resultPath)) {
            $fs->createDir($resultPath);
        }

        return $resultPath;
    }
}