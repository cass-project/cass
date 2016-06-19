<?php
namespace Domain\Profile\Service;

use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Service\AvatarService;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Gender\Gender;
use Domain\Profile\Entity\Profile\Greetings\Greetings;
use Domain\Profile\Exception\LastProfileException;
use Domain\Profile\Exception\MaxProfilesReachedException;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\Middleware\Parameters\ExpertInParameters;
use Domain\Profile\Middleware\Parameters\InterestingInParameters;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Profile\Strategy\ProfileImageStrategy;
use Domain\Profile\Validation\ProfileValidationService;
use League\Flysystem\Filesystem;

class ProfileService
{
    const MAX_PROFILES_PER_ACCOUNT = 10;

    /** @var ProfileValidationService */
    private $validation;

    /** @var ProfileRepository */
    private $profileRepository;

    /** @var AccountService */
    private $accountService;

    /** @var CollectionService */
    private $collectionService;

    /** @var Filesystem */
    private $imagesFlySystem;

    /** @var AvatarService */
    private $avatarService;

    public function __construct(
        ProfileValidationService $validationService,
        ProfileRepository $profileRepository,
        CollectionService $collectionService,
        Filesystem $imagesFlySystem,
        AvatarService $avatarService
    ) {
        $this->validation = $validationService;
        $this->profileRepository = $profileRepository;
        $this->collectionService = $collectionService;
        $this->imagesFlySystem = $imagesFlySystem;
        $this->avatarService = $avatarService;
    }

    public function worksWithAccountService(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function getProfileById(int $profileId): Profile
    {
        return $this->profileRepository->getProfileById($profileId);
    }

    public function getMaxProfilesPerAccount(): int
    {
        return self::MAX_PROFILES_PER_ACCOUNT;
    }

    public function createProfileForAccount(Account $account): Profile
    {
        if ($account->getProfiles()->count() >= self::MAX_PROFILES_PER_ACCOUNT) {
            throw new MaxProfilesReachedException(sprintf('You can only have %d profiles per account', self::MAX_PROFILES_PER_ACCOUNT));
        }

        $account->getProfiles()->add(
            $profile = new Profile($account)
        );

        $this->profileRepository->createProfile($profile);
        $this->collectionService->createDefaultCollectionForProfile($profile);

        return $profile;
    }

    public function updatePersonalData(int $profileId, EditPersonalParameters $parameters): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setGreetings(Greetings::createFromMethod($parameters->getMethod(), [
            'first_name' => $parameters->getFirstName(),
            'last_name' => $parameters->getLastName(),
            'middle_name' => $parameters->getMiddleName(),
            'nick_name' => $parameters->getNickName(),
        ]));

        if ($parameters->isGenderSpecified()) {
            $profile->setGender(Gender::createFromStringCode($parameters->getGender()));
        }

        return $this->profileRepository->saveProfile($profile);
    }

    public function deleteProfile(int $profileId): Profile
    {
        $profile = $this->getProfileById($profileId);
        $account = $profile->getAccount();

        $this->validation
            ->validateIsProfileOwnedByAccount($account, $profile)
        ;

        if ($account->getProfiles()->count() === 1) {
            throw new LastProfileException('This is your last profile. Sorry you need at least one profile per account.');
        }

        $this->profileRepository->deleteProfile($profile);
        $account->getProfiles()->removeElement($profile);

        if ($profile->isCurrent()) {
            $this->accountService->switchToProfile($account, $account->getProfiles()->first());
        }

        return $account->getCurrentProfile();
    }

    public function setGreetings(int $profileId, Greetings $greetings): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setGreetings($greetings);

        $this->profileRepository->saveProfile($profile);

        return $profile;
    }

    public function uploadImage(int $profileId, UploadImageParameters $parameters): ImageCollection
    {
        $profile = $this->getProfileById($profileId);
        $strategy = new ProfileImageStrategy($profile, $this->imagesFlySystem);

        $this->avatarService->uploadImage($strategy, $parameters);
        $this->profileRepository->saveProfile($profile);

        return $profile->getImages();
    }

    public function deleteProfileImage(int $profileId): ImageCollection
    {
        $profile = $this->getProfileById($profileId);
        $strategy = new ProfileImageStrategy($profile, $this->imagesFlySystem);

        $this->avatarService->generateImage($strategy);
        $this->profileRepository->saveProfile($profile);

        return $profile->getImages();
    }

    public function setInterestingInThemes(int $profileId, InterestingInParameters $inParameters): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setInterestingInIds($inParameters->getThemeIds());

        $this->profileRepository->saveProfile($profile);

        return $profile;
    }

    public function setExpertsInThemes(int $profileId, ExpertInParameters $expertInParameters): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setExpertInIds($expertInParameters->getThemeIds());

        $this->profileRepository->saveProfile($profile);

        return $profile;
    }
}