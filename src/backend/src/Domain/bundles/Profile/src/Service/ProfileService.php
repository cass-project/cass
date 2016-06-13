<?php
namespace Domain\Profile\Service;

use Domain\Account\Entity\Account;
use Application\Exception\PermissionsDeniedException;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Colors\Entity\Color;
use Domain\Colors\Service\ColorsService;
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

    /** @var CollectionRepository */
    private $collectionRepository;

    /** @var string */
    private $profileStorageDir;

    private $fontPath;
    /** @var ColorsService */
    private $colorsService;

    public function __construct(ProfileRepository $profileRepository, string $profileStorageDir, CollectionRepository $collectionRepository, string $fontPath, ColorsService $colorsService) {
        $this->profileRepository = $profileRepository;
        $this->profileStorageDir = $profileStorageDir;
        $this->collectionRepository = $collectionRepository;
        $this->fontPath = $fontPath;
        $this->colorsService = $colorsService;
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

        if ($parameters->isGenderSpecified()) {
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

        $profile
            ->setProfileGreetings(new ProfileGreetings($profile))
            ->setProfileImage(new ProfileImage($profile));

        $this->profileRepository->createProfile($profile);
        $this->profileRepository->switchTo($account->getProfiles()->toArray(), $profile);

        $collectionParameters = new CreateCollectionParameters('$gt_collection_my-feed_title', '$gt_collection_my-feed_description');
        $collection = $this->collectionRepository->createCollection("profile:{$profile->getId()}", $collectionParameters);

        $profile->getCollections()->attachChild($collection->getId());

        $this->generateProfileImage($profile->getId());

        $this->profileRepository->updateProfile($profile);

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

        if ($profile->isCurrent()) {
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

        if (file_exists($storagePath)) {
            if (!is_writable($storagePath)) {
                throw new \Exception('No permissions to delete profile avatar');
            }

            unlink($storagePath);
        }

        return $this->profileRepository->deleteProfileImage($profile);
    }

    public function nameFL(int $profileId, string $firstName, string $lastName) {
        $this->profileRepository->nameFL($profileId, $firstName, $lastName);
        $this->profileRepository->setAsInitialized($profileId);
        $this->generateProfileImage($profileId, $firstName[0]);
    }

    public function nameLFM(int $profileId, string $lastName, string $firstName, string $middleName) {
        $this->profileRepository->nameLFM($profileId, $lastName, $firstName, $middleName);
        $this->profileRepository->setAsInitialized($profileId);
        $this->generateProfileImage($profileId, $lastName[0]);
    }

    public function nameN(int $profileId, string $nickName) {
        $this->profileRepository->nameN($profileId, $nickName);
        $this->profileRepository->setAsInitialized($profileId);
        $this->generateProfileImage($profileId, $nickName[0]);
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

    public function generateProfileImage(int $profileId, string $char='T')
    {
        $char = strtoupper($char);
        $profile = $this->profileRepository->getProfileById($profileId);
        $profile_image = $this->profileRepository->deleteProfileImage($profile);

        $storageDir = sprintf('%s/%s',$this->profileStorageDir, $profileId);

        if(!is_dir($storageDir)) mkdir($storageDir);
        $storagePath = sprintf('%s/%s',$storageDir ,'profile_image.png');
        $im = imagecreatetruecolor(ProfileImage::MIN_WIDTH, ProfileImage::MIN_HEIGHT);

        $colors = array_filter($this->colorsService->getColors(),function(Color $color){
            return preg_match('#.700$#',$color->getCode());
        });

        /** @var Color $color */
        $color = $colors[array_rand($colors, 1)];
        $colorRGB = $color->toRGB();

        /** @var Color $textColor */
        $textColor = $this->colorsService->getColors()[sprintf("%s.100",$color->getName())];
        $textColorRGB = $textColor->toRGB();

        $image_color = imagecolorallocatealpha($im,$colorRGB[0],$colorRGB[1],$colorRGB[2],0);
        imagefill($im, 0,0,$image_color);
        $text_color = imagecolorallocate($im,$textColorRGB[0],$textColorRGB[1],$textColorRGB[2]);

        $size = ProfileImage::MIN_HEIGHT*0.9;
        $x = (ProfileImage::MIN_HEIGHT-$size);
        $y = ProfileImage::MIN_HEIGHT-5;

        imagettftext($im, $size, 0, $x,  $y, $text_color, $this->fontPath, $char );
        imagepng($im, $storagePath);

        $profile_image->setStoragePath($storagePath);
    }
}