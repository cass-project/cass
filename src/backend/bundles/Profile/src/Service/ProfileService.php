<?php
namespace Profile\Service;

use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\ImageWorkshop;
use Profile\Entity\Profile;
use Profile\Entity\ProfileImage;
use Profile\Exception\ImageTooSmallException;
use Profile\Repository\ProfileRepository;

class ProfileService
{
    /** @var ProfileRepository */
    private $profileRepository;

    /** @var string */
    private $profileStorageDir;

    public function __construct(ProfileRepository $profileRepository, string $profileStorageDir)
    {
        $this->profileRepository = $profileRepository;
        $this->profileStorageDir = $profileStorageDir;
    }

    public function getProfileById(int $profileId): Profile
    {
        return $this->profileRepository->getProfileById($profileId);
    }

    public function nameFL(int $profileId, string $firstName, string $lastName)
    {
        $this->profileRepository->nameFL($profileId, $firstName, $lastName);
    }

    public function nameLFM(int $profileId, string $lastName, string $firstName, string $middleName)
    {
        $this->profileRepository->nameLFM($profileId, $lastName, $firstName, $middleName);
    }

    public function nameN(int $profileId, string $nickName)
    {
        $this->profileRepository->nameN($profileId, $nickName);
    }

    public function uploadImage(int $profileId, string $tmpFile, int $startX, int $startY, int $endX, int $endY)
    {
        $profile = $this->getProfileById($profileId);

        if(!$profile->hasId()) {
            throw new \Exception('Unable to upload image for new non-persisted profile');
        }

        $this->validateCropPoints($image = ImageWorkshop::initFromPath($tmpFile), $startX, $startY, $endX, $endY);

        $image->crop(ImageWorkshopLayer::UNIT_PIXEL, $endX - $startX, $endY - $startY, $startX, $startY);
        $image->save($this->profileStorageDir, $imageFileName = sprintf('%d.png', $profile->getId()), false, 'ffffff');

        $storagePath = $this->profileStorageDir.'/'.$imageFileName;
        $publicPath = '/public/storage/'.$imageFileName;

        $this->profileRepository->updateImage($profile->getId(), $storagePath, $publicPath);
    }

    private function validateCropPoints(ImageWorkshopLayer $image, int $startX, int $startY, int $endX, int $endY)
    {
        if ($startX < 0 || $startY < 0) {
            throw new \OutOfBoundsException('startX/startY should be more than zero');
        }

        if ($endX > $image->getWidth() || $endY > $image->getHeight()) {
            throw new \OutOfBoundsException('endX/endY should be lest than image width/height');
        }

        if (($endX - $startX) < ProfileImage::MIN_WIDTH) {
            throw new ImageTooSmallException(sprintf('Image width should me more than %s pixels', ProfileImage::MIN_WIDTH));
        }

        if (($endY - $startY) < ProfileImage::MIN_HEIGHT) {
            throw new ImageTooSmallException(sprintf('Image height should me more than %s pixels', ProfileImage::MIN_HEIGHT));
        }
    }
}