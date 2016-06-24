<?php
namespace Domain\Avatar\Service;

use Application\Util\GenerateRandomString;
use Domain\Avatar\Exception\InvalidCropException;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Service\Strategy\AvatarServiceStrategy;
use Domain\Avatar\Strategy\ImageStrategy;
use Domain\Colors\Entity\Color;
use Domain\Colors\Service\ColorsService;
use Intervention\Image\ImageManagerStatic as Image;
use League\Flysystem\FilesystemInterface;

final class AvatarService
{
    const GENERATE_FILENAME_LENGTH = 8;

    /** @var AvatarServiceStrategy */
    private $strategy;

    private $colorsService;

    private $fontPath;

    public function __construct(AvatarServiceStrategy $strategy, ColorsService $colorsService,string $fontPath)
    {
        $this->strategy = $strategy;
        $this->colorsService = $colorsService;
        $this->fontPath = $fontPath;
    }

    public function defaultImage(ImageStrategy $strategy): ImageCollection
    {
        $this->destroyImages($strategy);

        $oldCollectionUID = $strategy->getEntity()->hasImages()
            ? $oldCollectionUID = $strategy->getEntity()->getImages()->getUID()
            : false
        ;

        $this->setImages($strategy, $this->strategy->generateImagesFromPath(
            $strategy,
            $strategy->getDefaultImage()->getStoragePath()
        ));

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
            $collection->attachImage('original', clone $collection->getImage(min($sizes)));
        }

        $strategy->getEntity()->setImages($collection);
    }

    public function generateImage(ImageStrategy $strategy): ImageCollection
    {
        return $this->defaultImage($strategy);
        $path = sprintf('%S/%s.jpg',$strategy->getPublicPath(), GenerateRandomString::gen(8));

        $colors = array_filter($this->colorsService->getColors(),function(Color $color){
            return preg_match('#.700$#',$color->getCode());
        });

        /** @var Color $bgColor */
        $bgColor = $colors[array_rand($colors, 1)];
        /** @var Color $textColor */
        $textColor = $this->colorsService->getColors()[sprintf("%s.100", $bgColor->getName())];

        $img = Image::canvas(64, 64, $bgColor->getHexCode());
        $char = strtoupper($strategy->getLetter());
        $fontPath = $this->fontPath;

        $img->text($char, 5, 5, function($font)use($textColor, $fontPath) {
            $font->file($fontPath);
            $font->size(24);
            $font->color($textColor->getHexCode());
            $font->align('center');
            $font->valign('top');
        });

//        $img->save($path);
        print_r($path);
        die('>>>>>>>>>>>>');
    }

    public function destroyImages(ImageStrategy $strategy)
    {
        $fs = $strategy->getFilesystem();
        $dir = (string)$strategy->getEntityId();

        if($fs->has($dir)) {
            $fs->deleteDir($dir);
        }
    }
}