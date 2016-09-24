<?php
namespace CASS\Domain\Bundles\Backdrop\Service;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\ColorBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\PresetBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\UploadedBackdrop;
use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use CASS\Domain\Bundles\Colors\Entity\Color;
use CASS\Domain\Bundles\Colors\Entity\Palette;
use Intervention\Image\ImageManager;
use CASS\Util\FileNameFilter;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\NoneBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Exception\InvalidSizeException;
use CASS\Domain\Bundles\Backdrop\Exception\TooBigFileException;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;

final class BackdropService
{
    /** @var ImageManager */
    private $imageManager;

    public function backdropNone(BackdropEntityAware $entity): NoneBackdrop
    {
        $backdrop = new NoneBackdrop();

        $entity->setBackdrop(
            $backdrop
        );

        return $backdrop;
    }

    public function backdropColor(BackdropEntityAware $entity, Palette $palette): ColorBackdrop
    {
        $backdrop = new ColorBackdrop($palette);
        $entity->setBackdrop($backdrop);

        return $backdrop;
    }

    public function backdropPreset(BackdropEntityAware $entity, PresetFactory $factory, string $presetId): PresetBackdrop
    {
        $backdrop = $factory->createPreset($presetId);
        $entity->setBackdrop($backdrop);

        return $backdrop;
    }

    public function backdropUpload(BackdropEntityAware $entity, BackdropUploadStrategy $strategy, Color $textColor, string $tmpFile): UploadedBackdrop
    {
        $this->validateFile($strategy, $tmpFile);

        $fileName = FileNameFilter::filter(basename($tmpFile));
        $storagePath = sprintf('%s/%s', $strategy->getStoragePath(), $fileName);
        $publicPath = sprintf('%s/%s', $strategy->getPublicPath(), $fileName);

        $strategy->getFileSystem()->write($fileName, $tmpFile);

        $backdrop = new UploadedBackdrop(
            $storagePath,
            $publicPath,
            $textColor
        );

        $entity->setBackdrop($backdrop);

        return $backdrop;
    }

    private function validateFile(BackdropUploadStrategy $strategy, string $tmpFile)
    {
        if(filesize($tmpFile) > $strategy->getMaxFileSize()) {
            throw new TooBigFileException(sprintf('File is too big'));
        }

        $image = $this->imageManager->make($tmpFile);

        if($image->getWidth() < $strategy->getMinImageWidth() ||
            $image->getHeight() < $strategy->getMinImageHeight()
        ) {
            throw new InvalidSizeException('Image is too small');
        }

        if($image->getWidth() > $strategy->getMaxImageWidth() ||
            $image->getHeight() > $strategy->getMaxImageHeight()
        ) {
            throw new InvalidSizeException('Image is too big');
        }
    }
}