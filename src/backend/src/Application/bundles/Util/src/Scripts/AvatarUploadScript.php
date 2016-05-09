<?php
namespace Application\Util\Scripts;

use Application\Util\Definitions\Point;
use Application\Util\GenerateRandomString;
use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\ImageWorkshop;
use Zend\Diactoros\UploadedFile;

class AvatarUploadScriptException extends \Exception {}
class ImageTooSmallException extends AvatarUploadScriptException {}
class ImageTooBigException extends AvatarUploadScriptException {}
class ImageWrongAspectRatio extends AvatarUploadScriptException {}

abstract class AvatarUploadScript
{
    private $storageDir;

    public function __construct(string $storageDir) {
        $this->storageDir = $storageDir;
    }

    public function __invoke(int $entityId, string $file, Point $start, Point $end) {
        $image = ImageWorkshop::initFromPath($file);

        $this->validateImageSize($start, $end, $image);
        $this->cropImage($start, $end, $image);

        $resultDir = sprintf('%s/%d', $this->storageDir, $entityId);
        $resultFile = GenerateRandomString::gen(12).'.png';
        $resultPath = $resultDir.'/'.$resultFile;

        $image->save($resultDir, $resultFile, true, 'ffffff');

        return [
            'id' => $entityId,
            'dir' => $resultDir,
            'file' => $resultFile,
            'path' => $resultPath
        ];
    }

    protected abstract function aspectRatio();
    protected abstract function getMinImageWidth(): int;
    protected abstract function getMaxImageWidth(): int;
    protected abstract function getMinImageHeight(): int;
    protected abstract function getMaxImageHeight(): int;

    private function validateImageSize(Point $start, Point $end, ImageWorkshopLayer $image) {
        $startX = $start->getX();
        $startY = $start->getY();
        $endX = $end->getX();
        $endY = $end->getY();

        if ($startX < 0 || $startY < 0) {
            throw new \OutOfBoundsException('startX/startY should be more than zero');
        }

        if ($endX > $image->getWidth() || $endY > $image->getHeight()) {
            throw new AvatarUploadScriptException('endX/endY should be lest than image width/height');
        }

        $resultWidth = ($endX - $startX);
        $resultHeight = ($endY - $startY);

        if ($resultWidth > $this->getMaxImageWidth()) {
            throw new ImageTooSmallException(sprintf('Image width should me less than %s pixels', $this->getMaxImageWidth()));
        }

        if ($resultHeight > $this->getMaxImageHeight()) {
            throw new ImageTooSmallException(sprintf('Image height should me more than %s pixels', $this->getMinImageHeight()));
        }

        if ($resultWidth < $this->getMinImageWidth()) {
            throw new ImageTooSmallException(sprintf('Image width should me more than %s pixels', $this->getMinImageWidth()));
        }

        if ($resultHeight < $this->getMinImageHeight()) {
            throw new ImageTooSmallException(sprintf('Image height should me more than %s pixels', $this->getMinImageHeight()));
        }

        if ($ratio = $this->aspectRatio()) {
            $ratio1 = $resultWidth / $resultHeight;
            $ratio2 = $resultHeight / $resultWidth;
            $resultRatio = sprintf("%s:%s", $ratio1, $ratio2);

            if($resultRatio !== $ratio) {
                throw new ImageWrongAspectRatio(sprintf('Wrong aspect ratio, expect `%s`, got `%s`', $ratio, $resultRatio));
            }
        }
    }

    private function cropImage(Point $start, Point $end, ImageWorkshopLayer $image) {
        $image->crop(ImageWorkshopLayer::UNIT_PIXEL, $end->getX() - $start->getX(), $end->getY() - $start->getY(), $start->getX(), $start->getY());
    }
}