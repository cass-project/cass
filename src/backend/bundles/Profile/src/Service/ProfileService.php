<?php
namespace Profile\Service;

use Account\Entity\Account;
use Common\Exception\PermissionsDeniedException;
use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\ImageWorkshop;
use Profile\Entity\Profile;
use Profile\Entity\ProfileGreetings;
use Profile\Entity\ProfileImage;
use Profile\Exception\ImageIsNotASquareException;
use Profile\Exception\ImageTooBigException;
use Profile\Exception\ImageTooSmallException;
use Profile\Exception\LastProfileException;
use Profile\Exception\MaxProfilesReachedException;
use Profile\Repository\ProfileRepository;

class ProfileService
{
    const MAX_PROFILES_PER_ACCOUNT = 10;

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

    public function createProfileForAccount(Account $account): Profile
    {
        if ($account->getProfiles()->count() >= self::MAX_PROFILES_PER_ACCOUNT) {
            throw new MaxProfilesReachedException(sprintf('You can only have %d profiles per account', self::MAX_PROFILES_PER_ACCOUNT));
        }

        $account->getProfiles()->add($profile = new Profile($account));

        $profile->setIsCurrent(true)
            ->setProfileGreetings(new ProfileGreetings($profile))
            ->setProfileImage(new ProfileImage($profile));

        return $this->profileRepository->createProfile($profile);
    }

    public function deleteProfile(int $profileId, int $currentAccountId)
    {
        $profile = $this->getProfileById($profileId);
        $account = $profile->getAccount();

        if($account->getId() !== $currentAccountId) {
            throw new PermissionsDeniedException("You're not an owner of this profile");
        }

        if($account->getProfiles()->count() === 1) {
            throw new LastProfileException('This is your last profile. Sorry you need at least one profile per account.');
        }

        $this->profileRepository->deleteProfile($profile);
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

    public function uploadImage(int $profileId, string $tmpFile, int $startX, int $startY, int $endX, int $endY): ProfileImage
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

        return $this->profileRepository->updateImage($profile->getId(), $storagePath, $publicPath);
    }

    private function validateCropPoints(ImageWorkshopLayer $image, int $startX, int $startY, int $endX, int $endY)
    {
        if ($startX < 0 || $startY < 0) {
            throw new \OutOfBoundsException('startX/startY should be more than zero');
        }

        if ($endX > $image->getWidth() || $endY > $image->getHeight()) {
            throw new \OutOfBoundsException('endX/endY should be lest than image width/height');
        }

        $resultWidth = ($endX - $startX);
        $resultHeight = ($endY - $startY);

        if ($resultWidth < ProfileImage::MIN_WIDTH) {
            throw new ImageTooSmallException(sprintf('Image width should me more than %s pixels', ProfileImage::MIN_WIDTH));
        }

        if ($resultHeight < ProfileImage::MIN_HEIGHT) {
            throw new ImageTooSmallException(sprintf('Image height should me more than %s pixels', ProfileImage::MIN_HEIGHT));
        }

        if($resultWidth > ProfileImage::MAX_WIDTH) {
            throw new ImageTooBigException(sprintf('Image width should me less than %s pixels', ProfileImage::MAX_WIDTH));
        }

        if($resultHeight > ProfileImage::MAX_HEIGHT) {
            throw new ImageTooBigException(sprintf('Image height should me less than %s pixels', ProfileImage::MAX_HEIGHT));
        }

        if($resultWidth !== $resultHeight) {
            throw new ImageIsNotASquareException('Image should be a square');
        }
    }
}