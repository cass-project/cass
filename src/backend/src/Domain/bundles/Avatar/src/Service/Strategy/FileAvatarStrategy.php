<?php
namespace Domain\Avatar\Service\Strategy;

use Application\Util\GenerateRandomString;
use Domain\Avatar\Exception\InvalidRatioException;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Strategy\ImageStrategy;
use Intervention\Image\ImageManager;
use Intervention\Image\Image as ImageLayer;
use League\Flysystem\FilesystemInterface;

final class FileAvatarStrategy implements AvatarServiceStrategy
{
    const GENERATE_FILENAME_LENGTH = 8;

    /** @var ImageManager */
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function getImageFromPath(string $path): ImageLayer
    {
        return $this->imageManager->make($path);
    }

    public function cropImage(ImageLayer $source, int $width, int $height, int $startX, int $startY): ImageLayer
    {
        $source->crop($width, $height, $startX, $startY);

        return $source;
    }

    public function generateImagesFromPath(ImageStrategy $strategy, string $path): ImageCollection
    {
        return $this->generateImagesFromSource($strategy, $this->imageManager->make($path));
    }

    public function generateImagesFromSource(ImageStrategy $strategy, ImageLayer $source): ImageCollection
    {
        $collection = new ImageCollection();

        array_map(function(int $size) use ($source, $collection, $strategy) {
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

            $dir = $this->touchDir($strategy->getFilesystem(), $strategy->getEntityId(), $collection->getUID(), $size);
            $file = sprintf('%s.png', GenerateRandomString::gen(self::GENERATE_FILENAME_LENGTH));

            $strategy->getFilesystem()->write("{$dir}/{$file}", $image->encode('png'));

            $collection->attachImage((string) $size, new Image(
                "{$dir}/{$file}",
                sprintf("%s/%s/%s/%s", $strategy->getPublicPath(), $strategy->getEntityId(), $size, $file)
            ));
        }, $strategy->getSizes());

        return $collection;
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