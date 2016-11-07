<?php
namespace CASS\Domain\Bundles\Profile\Service;

use CASS\Application\Service\EventEmitterAware\EventEmitterAwareService;
use CASS\Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Account\Service\AccountService;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Avatar\Image\ImageCollection;
use CASS\Domain\Bundles\Avatar\Parameters\UploadImageParameters;
use CASS\Domain\Bundles\Avatar\Service\AvatarService;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Profile\Backdrop\Preset\ProfileBackdropPresetFactory;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\Gender;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings\Greetings;
use CASS\Domain\Bundles\Profile\Exception\LastProfileException;
use CASS\Domain\Bundles\Profile\Exception\MaxProfilesReachedException;
use CASS\Domain\Bundles\Profile\Parameters\EditPersonalParameters;
use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use CASS\Domain\Bundles\Profile\Image\ProfileImageStrategy;
use League\Flysystem\FilesystemInterface;

final class ProfileService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const EVENT_PROFILE_ACCESS = 'domain.profile.access';
    const EVENT_PROFILE_CREATED = 'domain.profile.create';
    const EVENT_PROFILE_UPDATED = 'domain.profile.update';
    const EVENT_PROFILE_DELETE = 'domain.profile.delete';
    const EVENT_PROFILE_DELETED = 'domain.profile.deleted';

    const MAX_PROFILES_PER_ACCOUNT = 10;

    private $disableAutoImageGeneration = false;

    /** @var ProfileRepository */
    private $profileRepository;

    /** @var ProfileCardService */
    private $profileCardService;

    /** @var AccountService */
    private $accountService;

    /** @var CollectionService */
    private $collectionService;

    /** @var AvatarService */
    private $avatarService;

    /** @var BackdropService */
    private $backdropService;

    /** @var ProfileBackdropPresetFactory */
    private $backdropPresetFactory;

    /** @var FilesystemInterface */
    private $imagesFlySystem;
    
    /** @var string */
    private $wwwImagesDir;

    public function __construct(
        CurrentAccountService $currentAccountService,
        ProfileRepository $profileRepository,
        ProfileCardService $profileCardService,
        CollectionService $collectionService,
        AvatarService $avatarService,
        BackdropService $backdropService,
        ProfileBackdropPresetFactory $presetFactory,
        FilesystemInterface $imagesFlySystem,
        string $wwwImagesDir
    )
    {
        $this->profileRepository = $profileRepository;
        $this->profileCardService = $profileCardService;
        $this->collectionService = $collectionService;
        $this->avatarService = $avatarService;
        $this->backdropService = $backdropService;
        $this->backdropPresetFactory = $presetFactory;
        $this->imagesFlySystem = $imagesFlySystem;
        $this->wwwImagesDir = $wwwImagesDir;
    }

    public function disableAutoImageGeneration()
    {
        $this->disableAutoImageGeneration = true;
    }

    public function worksWithAccountService(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function getProfileById(int $profileId): Profile
    {
        return $this->profileRepository->getProfileById($profileId);
    }
    
    public function getProfilesByIds(array $profileIds): array
    {
        return $this->profileRepository->getProfileByIds($profileIds);
    }
    
    public function loadProfilesByIds(array $profileIds)
    {
        $this->profileRepository->loadProfilesByIds($profileIds);
    }
    
    public function getProfileBySID(string $profileSid): Profile
    {
        return $this->profileRepository->getProfileBySID($profileSid);
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
        $this->accountService->switchToProfile($account, $profile->getId());

        if(! $this->disableAutoImageGeneration) {
            $this->generateProfileImage($profile->getId());
        }

        $this->backdropService->backdropPreset($profile, $this->backdropPresetFactory, $this->backdropPresetFactory->getListIds()[array_rand($this->backdropPresetFactory->getListIds())]);

        $this->getEventEmitter()->emit(self::EVENT_PROFILE_CREATED, [$profile]);

        return $profile;
    }

    public function saveProfile(Profile $profile):Profile
    {
        return $this->profileRepository->saveProfile($profile);
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

        if($parameters->isAvatarRegenetateRequested()) {
            $this->avatarService->generateImage(new ProfileImageStrategy($profile, $this->imagesFlySystem, $this->wwwImagesDir));
        }

        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile;
    }

    public function deleteProfile(int $profileId): Profile
    {
        $profile = $this->getProfileById($profileId);
        $account = $profile->getAccount();

        if ($account->getProfiles()->count() === 1) {
            throw new LastProfileException('This is your last profile. Sorry you need at least one profile per account.');
        }

        $this->getEventEmitter()->emit(self::EVENT_PROFILE_DELETE, [$profile]);
        $this->profileRepository->deleteProfile($profile);
        $account->getProfiles()->removeElement($profile);

        if ($profile->isCurrent()) {
            $firstProfile =  $account->getProfiles()->first(); /** @var Profile $firstProfile */
            $this->accountService->switchToProfile($account, $firstProfile->getId());
        }

        $this->getEventEmitter()->emit(self::EVENT_PROFILE_DELETED, [$profile]);

        return $account->getCurrentProfile();
    }

    public function setGreetings(int $profileId, Greetings $greetings): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setGreetings($greetings);

        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile;
    }

    public function setGender(int $profileId, Gender $gender): Gender
    {
        $profile = $this->getProfileById($profileId);
        $profile->setGender($gender);

        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getGender();
    }

    public function setBirthday(int $profileId, \DateTime $birthday)
    {
        $profile = $this->getProfileById($profileId);
        $profile->setBirthday($birthday);

        $this->profileRepository->saveProfile($profile);
    }

    public function unsetBirthday(int $profileId)
    {
        $profile = $this->getProfileById($profileId);
        $profile->unsetBirthday();

        $this->profileRepository->saveProfile($profile);
    }

    public function uploadImage(int $profileId, UploadImageParameters $parameters): ImageCollection
    {
        $profile = $this->getProfileById($profileId);
        $strategy = new ProfileImageStrategy($profile, $this->imagesFlySystem, $this->wwwImagesDir);

        $this->avatarService->uploadImage($strategy, $parameters);
        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getImages();
    }

    public function deleteProfileImage(int $profileId): ImageCollection
    {
        $profile = $this->getProfileById($profileId);

        $this->generateProfileImage($profileId);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getImages();
    }

    public function generateProfileImage(int $profileId): ImageCollection
    {
        $profile = $this->getProfileById($profileId);
        $strategy = new ProfileImageStrategy($profile, $this->imagesFlySystem, $this->wwwImagesDir);

        $this->avatarService->generateImage($strategy);
        $this->profileRepository->saveProfile($profile);

        return $profile->getImages();
    }

    public function setInterestingInThemes(int $profileId, array $themeIds): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setInterestingInIds($themeIds);

        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile;
    }

    public function setExpertsInThemes(int $profileId, array $themeIds): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setExpertInIds($themeIds);

        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile;
    }

    public function linkCollection(int $profileId, int $collectionId): ImmutableCollectionTree
    {
        $profile = $this->getProfileById($profileId);

        $collections = $profile->getCollections()->createMutableInstance();

        if(! $collections->hasCollection($collectionId)) {
            $collections->attachChild($collectionId);
        }

        $profile->replaceCollections($collections->createImmutableInstance());

        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getCollections();
    }

    public function unlinkCollection(int $profileId, int $collectionId): ImmutableCollectionTree
    {
        $profile = $this->getProfileById($profileId);

        $collections = $profile->getCollections()->createMutableInstance();

        if($collections->hasCollection($collectionId)) {
            $collections->detachChild($collectionId);
        }

        $profile->replaceCollections($collections->createImmutableInstance());

        $this->profileRepository->saveProfile($profile);
        $this->getEventEmitter()->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getCollections();
    }
}