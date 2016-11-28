<?php
namespace CASS\Domain\Bundles\Backdrop\Service;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\ColorBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\PresetBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\UploadedBackdrop;
use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use CASS\Domain\Bundles\Colors\Entity\Color;
use CASS\Domain\Bundles\Colors\Entity\Palette;
use CASS\Util\GenerateRandomString;
use Intervention\Image\Image;
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

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

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

    public function backdropUpload(
        BackdropEntityAware $entity,
        BackdropUploadStrategy $strategy,
        string $textColor,
        string $tmpFile
    ): UploadedBackdrop
    {
        $image = $this->validateFile($strategy, $tmpFile);

        $uid = join('/', str_split($entity->getSID(), 2));

        $pathInfo = pathinfo($tmpFile);

        $fileName = GenerateRandomString::gen(8) .'_'. FileNameFilter::filter($pathInfo['basename']).'.png';
        $storagePath = sprintf('%s/%s', $uid, $fileName);
        $publicPath = sprintf('%s/%s/%s', $strategy->getPublicPath(), $uid, $fileName);

        $strategy->getFileSystem()->write($storagePath, $image->encode('png'));

        $backdrop = new UploadedBackdrop(
            $storagePath,
            $publicPath,
            $textColor
        );

        $entity->setBackdrop($backdrop);

        return $backdrop;
    }

    private function validateFile(BackdropUploadStrategy $strategy, string $tmpFile): Image
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

        return $image;
    }
}