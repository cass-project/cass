<?php
namespace CASS\Domain\Avatar\Service;

use CASS\Domain\Avatar\Exception\InvalidCropException;
use CASS\Domain\Avatar\Image\ImageCollection;
use CASS\Domain\Avatar\Parameters\UploadImageParameters;
use CASS\Domain\Avatar\Service\Strategy\AvatarServiceStrategy;
use CASS\Domain\Avatar\Strategy\ImageStrategy;

final class AvatarService
{
    const GENERATE_FILENAME_LENGTH = 8;

    /** @var AvatarServiceStrategy */
    private $strategy;

    public function __construct(AvatarServiceStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function defaultImage(ImageStrategy $strategy): ImageCollection
    {
        $this->destroyImages($strategy);

        $oldCollectionUID = $strategy->getEntity()->hasImages()
            ? $oldCollectionUID = $strategy->getEntity()->getImages()->getUID()
            : false
        ;

        $images = $this->strategy->generateImagesFromPath($strategy, $strategy->getDefaultImage()->getStoragePath());
        $images->markAsAutoGenerated();

        $this->setImages($strategy, $images);

        if($oldCollectionUID) {
            $strategy->getFilesystem()->deleteDir(sprintf('%s/%s', $strategy->getEntityId(), $oldCollectionUID));
        }

        return $strategy->getEntity()->getImages();
    }

    public function uploadImage(ImageStrategy $strategy, UploadImageParameters $parameters): ImageCollection
    {
        $oldCollectionUID = null;

        if($strategy->getEntity()->hasImages()) {
            $oldCollectionUID = $strategy->getEntity()->getImages()->getUID();
        }

        $this->destroyImages($strategy);

        $start = $parameters->getPointStart();
        $end = $parameters->getPointEnd();

        $source = $this->strategy->getImageFromPath($parameters->getTmpFile());

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

        $source = $this->strategy->cropImage(
            $source,
            $end->getX() - $start->getX(),
            $end->getY() - $start->getY(),
            $start->getX(), 
            $start->getY()
        );

        $strategy->validate($source);
        $this->setImages($strategy, $this->strategy->generateImagesFromSource($strategy, $source));

        if($oldCollectionUID) {
            $strategy->getFilesystem()->deleteDir(sprintf('%s/%s', $strategy->getEntityId(), $oldCollectionUID));
        }

        return $strategy->getEntity()->getImages();
    }

    private function setImages(ImageStrategy $strategy, ImageCollection $collection)
    {
        if($collection->hasImage($strategy->getDefaultSize())) {
            $collection->attachImage('default', clone $collection->getImage((string) $strategy->getDefaultSize()));
        }else{
            $collection->attachImage('default', clone $collection->getImage(max($strategy->getSizes())));
        }

        $strategy->getEntity()->setImages($collection);
    }

    public function generateImage(ImageStrategy $strategy): ImageCollection
    {
        $this->destroyImages($strategy);

        $oldCollectionUID = $strategy->getEntity()->hasImages()
            ? $oldCollectionUID = $strategy->getEntity()->getImages()->getUID()
            : false
        ;

        $images = $this->strategy->generateImagesFromLetter($strategy, $strategy->getLetter());
        $images->markAsAutoGenerated();

        $this->setImages($strategy, $images);

        if($oldCollectionUID) {
            $strategy->getFilesystem()->deleteDir(sprintf('%s/%s', $strategy->getEntityId(), $oldCollectionUID));
        }

        return $strategy->getEntity()->getImages();
    }

    public function destroyImages(ImageStrategy $strategy)
    {
        $fs = $strategy->getFilesystem();
        $dir = (string) $strategy->getEntityId();

        if($fs->has($dir)) {
            $fs->deleteDir($dir);
        }
    }
}