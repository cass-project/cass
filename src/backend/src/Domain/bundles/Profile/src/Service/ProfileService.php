<?php
namespace Domain\Profile\Service;

use Domain\Account\Entity\Account;
use Application\Exception\PermissionsDeniedException;
use Domain\Collection\Entity\Collection;
use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\ImageWorkshop;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\ProfileGreetings;
use Domain\Profile\Entity\ProfileImage;
use Domain\Profile\Exception\ImageIsNotASquareException;
use Domain\Profile\Exception\ImageTooSmallException;
use Domain\Profile\Exception\LastProfileException;
use Domain\Profile\Exception\MaxProfilesReachedException;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\Middleware\Parameters\ExpertInParameters;
use Domain\Profile\Middleware\Parameters\InterestingInParameters;
use Domain\Profile\Repository\ProfileRepository;
use Application\Util\GenerateRandomString;

class ProfileService
{
    const MAX_PROFILES_PER_ACCOUNT = 10;

    /** @var ProfileRepository */
    private $profileRepository;

    /** @var string */
    private $profileStorageDir;

    public function __construct(ProfileRepository $profileRepository, string $profileStorageDir) {
        $this->profileRepository = $profileRepository;
        $this->profileStorageDir = $profileStorageDir;
    }

    public function getProfileById(int $profileId): Profile {
        return $this->profileRepository->getProfileById($profileId);
    }

    public function updatePersonalData(int $profileId, EditPersonalParameters $parameters) {
        $profile = $this->getProfileById($profileId);
        $profile->getProfileGreetings()
            ->setGreetingsMethod($parameters->getGreetingsType())
            ->setFirstName($parameters->getFirstName())
            ->setLastName($parameters->getLastName())
            ->setMiddleName($parameters->getMiddleName())
            ->setNickName($parameters->getNickName());

        if($parameters->isGenderSpecified()) {
            $profile->setGenderFromStringCode($parameters->getGender());
        }

        $this->profileRepository->updateProfile($profile);

        return true;
    }

    public function createProfileForAccount(Account $account): Profile {
        if ($account->getProfiles()->count() >= self::MAX_PROFILES_PER_ACCOUNT) {
            throw new MaxProfilesReachedException(sprintf('You can only have %d profiles per account', self::MAX_PROFILES_PER_ACCOUNT));
        }

        $account->getProfiles()->add($profile = new Profile($account));

        $collection = new Collection($profile->getId(),'Моя лента', '');

        $profile
            ->setProfileGreetings(new ProfileGreetings($profile))
            ->setProfileImage(new ProfileImage($profile))
            ->setCollection($collection)
        ;

        $this->profileRepository->createProfile($profile);
        $this->profileRepository->switchTo($account->getProfiles()->toArray(), $profile);

        return $profile;
    }

    public function deleteProfile(int $profileId, int $currentAccountId) {
        $profile = $this->getProfileById($profileId);
        $account = $profile->getAccount();

        if ($account->getId() !== $currentAccountId) {
            throw new PermissionsDeniedException("You're not an owner of this profile");
        }

        if ($account->getProfiles()->count() === 1) {
            throw new LastProfileException('This is your last profile. Sorry you need at least one profile per account.');
        }

        $this->profileRepository->deleteProfile($profile);

        $account->getProfiles()->removeElement($profile);

        if($profile->isCurrent()) {
            $this->profileRepository->switchTo($account->getProfiles()->toArray(), $account->getProfiles()->first());
        }
    }

    public function deleteProfileImage(int $profileId, int $currentAccountId): ProfileImage {
        $profile = $this->getProfileById($profileId);
        $account = $profile->getAccount();

        if ($account->getId() !== $currentAccountId) {
            throw new PermissionsDeniedException("You're not an owner of this profile");
        }

        $storagePath = $profile->getProfileImage()->getStoragePath();

        if(file_exists($storagePath)) {
            if(!is_writable($storagePath)) {
                throw new \Exception('No permissions to delete profile avatar');
            }

            unlink($storagePath);
        }

        return $this->profileRepository->deleteProfileImage($profile);
    }

    public function nameFL(int $profileId, string $firstName, string $lastName) {
        $this->profileRepository->nameFL($profileId, $firstName, $lastName);
        $this->profileRepository->setAsInitialized($profileId);
    }

    public function nameLFM(int $profileId, string $lastName, string $firstName, string $middleName) {
        $this->profileRepository->nameLFM($profileId, $lastName, $firstName, $middleName);
        $this->profileRepository->setAsInitialized($profileId);
    }

    public function nameN(int $profileId, string $nickName) {
        $this->profileRepository->nameN($profileId, $nickName);
        $this->profileRepository->setAsInitialized($profileId);
    }

    public function switchTo(Account $account, int $profileId): Profile {
        $profile = $this->getProfileById($profileId);

        if (!$account->getProfiles()->contains($profile)) {
            throw new PermissionsDeniedException("You're not an owner of this profile");
        }

        $this->profileRepository->switchTo($account->getProfiles()->toArray(), $profile);

        return $profile;
    }

    public function uploadImage(int $profileId, string $tmpFile, int $startX, int $startY, int $endX, int $endY): ProfileImage {
        $profile = $this->getProfileById($profileId);

        if (!$profile->isPersisted()) {
            throw new \Exception('Unable to upload image for new non-persisted profile');
        }

        $this->validateCropPoints($image = ImageWorkshop::initFromPath($tmpFile), $startX, $startY, $endX, $endY);

        $image->crop(ImageWorkshopLayer::UNIT_PIXEL, $endX - $startX, $endY - $startY, $startX, $startY);

        $currentImageWidth = $image->getWidth();
        $currentImageHeight = $image->getWidth();

        if ($currentImageWidth > ProfileImage::MIN_WIDTH) {
            $scale = ProfileImage::MAX_WIDTH / $currentImageWidth;
            $newWidth = $currentImageWidth * $scale;
            $newHeight = $currentImageHeight * $scale;

            $image->resize(ImageWorkshopLayer::UNIT_PIXEL, $newWidth, $newHeight, false);
        }

        $oldProfileImage = $profile->getProfileImage()->isDefaultImage()
            ? false
            : $profile->getProfileImage()->getStoragePath();

        $imageFileName = sprintf('%s.png', GenerateRandomString::gen(12));
        $targetDir = (string)$profile->getId();

        $storagePath = sprintf('%s/%s/%s', $this->profileStorageDir, $targetDir, $imageFileName);
        $publicPath = sprintf('/public/storage/profile/profile-image/%d/%s', $targetDir, $imageFileName);

        $image->save(sprintf('%s/%s', $this->profileStorageDir, $targetDir), $imageFileName, true, 'ffffff');
        $newProfileImage = $this->profileRepository->updateImage($profile->getId(), $storagePath, $publicPath);

        if ($oldProfileImage && file_exists($oldProfileImage)) {
            unlink($oldProfileImage);
        }

        return $newProfileImage;
    }

    private function validateCropPoints(ImageWorkshopLayer $image, int $startX, int $startY, int $endX, int $endY) {
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

        if ($resultWidth !== $resultHeight) {
            throw new ImageIsNotASquareException('Image should be a square');
        }
    }
    
    public function setExpertsInParameters(int $profileId, ExpertInParameters $expertInParameters): Profile {
        return $this->profileRepository->setExpertsInParameters($profileId, $expertInParameters);
    }

    public function mergeExpertsInParameters(int $profileId, ExpertInParameters $expertInParameters): Profile {
        return $this->profileRepository->mergeExpertsInParameters($profileId, $expertInParameters);
    }

    public function setInterestingInParameters(int $profileId, InterestingInParameters $inParameters): Profile {
        return $this->profileRepository->setInterestingInParameters($profileId, $inParameters);
    }

    public function mergeInterestingInParameters(int $profileId, InterestingInParameters $inParameters): Profile {
        return $this->profileRepository->mergeInterestingInParameters($profileId, $inParameters);
    }


    public function deleteExpertsInParameters(int $profileId, array $expertInParameters): Profile {
        return $this->profileRepository->deleteExpertsInParameters($profileId, $expertInParameters);
    }

    public function deleteInterestingInParameters(int $profileId, array $interestingInParameters) {
        return $this->profileRepository->deleteInterestingInParameters($profileId, $interestingInParameters);
    }

    public function setGenderFromStringCode(int $profileId, string $genderCode): Profile {
        return $this->profileRepository->setGenderFromStringCode($profileId, $genderCode);
    }
}