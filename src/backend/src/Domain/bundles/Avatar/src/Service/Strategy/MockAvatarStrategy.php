<?php
namespace Domain\Avatar\Service\Strategy;

use Application\Util\GenerateRandomString;
use Domain\Avatar\Image\Image as ImageCollectionItem;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Strategy\ImageStrategy;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use League\Flysystem\FilesystemInterface;

final class MockAvatarStrategy implements AvatarServiceStrategy
{
    const GENERATE_FILENAME_LENGTH = 8;

    /** @var array ImageLayer[] */
    private $cachedSizes = [];

    /** @var ImageManager */
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function getImageFromPath(string $path): Image
    {
        return $this->createEmptyImage(600, 600);
    }

    public function cropImage(Image $source, int $width, int $height, int $startX, int $startY): Image
    {
        return $this->createEmptyImage($width, $height);
    }

    public function generateImagesFromPath(ImageStrategy $strategy, string $path): ImageCollection
    {
        return $this->createEmptyImages($strategy);
    }

    public function generateImagesFromSource(ImageStrategy $strategy, Image $source): ImageCollection
    {
        return $this->createEmptyImages($strategy);
    }

    private function createEmptyImage(int $width, int $height): Image
    {
        $sId = sprintf('%s-%s', $width, $height);

        if(! isset($this->cachedSizes[$sId])) {
            $this->cachedSizes[$sId] = $this->imageManager->canvas($width, $height, 'ffffff');
        }

        return clone $this->cachedSizes[$sId];
    }

    private function createEmptyImages(ImageStrategy $strategy): ImageCollection
    {
        $collection = new ImageCollection();

        array_map(function(int $size) use ($collection, $strategy) {
            $dir = $this->touchDir($strategy->getFilesystem(), $strategy->getEntityId(), $collection->getUID(), $size);
            $file = sprintf('%s.png', GenerateRandomString::gen(self::GENERATE_FILENAME_LENGTH));

            $strategy->getFilesystem()->write("{$dir}/{$file}", '');

            $collection->attachImage((string) $size, new ImageCollectionItem(
                "{$dir}/{$file}",
                sprintf("%s/%s/%s/%s", $strategy->getPublicPath(), $strategy->getEntityId(), $size, $file)
            ));
        }, $strategy->getSizes());

        return $collection;
    }

    public function generateImagesFromLetter(ImageStrategy $strategy, string $letter): ImageCollection
    {
        return $this->createEmptyImages($strategy);
    }

    private function touchDir(FilesystemInterface $fs, string $entityId, string $collectionUID, string $imageId): string
    {
        $resultPath = sprintf('%s/%s/%s', $entityId, $collectionUID, $imageId);

        if(!$fs->has($resultPath)) {
            $fs->createDir($resultPath);
        }

        return $resultPath;
    }
}