<?php
namespace Domain\Avatar\Service\Strategy;

use Application\Util\GenerateRandomString;
use Domain\Avatar\Exception\InvalidRatioException;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Strategy\ImageStrategy;
use Domain\Colors\Service\ColorsService;
use Intervention\Image\ImageManager;
use Intervention\Image\Image as ImageLayer;
use League\Flysystem\FilesystemInterface;
use Intervention\Image\Gd\Font;

final class FileAvatarStrategy implements AvatarServiceStrategy
{
    const GENERATE_FILENAME_LENGTH = 8;

    /** @var ImageManager */
    private $imageManager;

    /** @var ColorsService */
    private $colorsService;

    /** @var string */
    private $fontPath;

    public function __construct(
        ImageManager $imageManager,
        ColorsService $colorsService,
        string $fontPath
    ) {
        $this->imageManager = $imageManager;
        $this->colorsService = $colorsService;
        $this->fontPath = $fontPath;
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

    public function generateImagesFromLetter(ImageStrategy $strategy, string $letter): ImageCollection
    {
        $palette = $this->colorsService->getRandomPalette();
        $bgColor = $palette->getBackground();
        $textColor = $palette->getForeground();

        $size = max($strategy->getSizes());
        $fontSize = (int) $size * 0.8;

        $img = $this->imageManager->canvas($size, $size, $bgColor->getHexCode());
        $char = strtoupper($strategy->getLetter());
        $fontPath = $this->fontPath;

        $img->text($char, (int) $size/2, (int) $size/2, function(Font $font) use($fontSize, $textColor, $fontPath) {
            $font->file($fontPath);
            $font->size($fontSize);
            $font->color($textColor->getHexCode());
            $font->align('center');
            $font->valign('center');
        });

        return $this->generateImagesFromSource($strategy, $img);
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
                sprintf("%s/%s/%s/%s/%s", $strategy->getPublicPath(), $strategy->getEntityId(), $collection->getUID(), $size, $file)
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