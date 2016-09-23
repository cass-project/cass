<?php
namespace CASS\Domain\Bundles\Backdrop\Service;

use CASS\Util\FileNameFilter;
use Intervention\Image\ImageManager;
use CASS\Domain\Bundles\Backdrop\Exception\InvalidSizeException;
use CASS\Domain\Bundles\Backdrop\Exception\TooBigFileException;
use CASS\Domain\Bundles\Backdrop\Strategy\BackdropUploadStrategy;

final class BackdropService
{
    /** @var ImageManager */
    private $imageManager;

    public function upload(BackdropUploadStrategy $strategy, string $tmpFile)
    {
        $this->validateFile($strategy, $tmpFile);

        $fileName = FileNameFilter::filter(basename($tmpFile));
        $strategy->getFileSystem()->write($fileName, $tmpFile);
    }

    public function preset(BackdropUploadStrategy $strategy, string $presetId)
    {

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