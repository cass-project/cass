<?php
namespace Domain\Profile\Service;

use Domain\Account\Entity\Account;
use Domain\Account\Service\AccountService;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Service\AvatarService;
use Domain\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Gender\Gender;
use Domain\Profile\Entity\Profile\Greetings\Greetings;
use Domain\Profile\Exception\LastProfileException;
use Domain\Profile\Exception\MaxProfilesReachedException;
use Domain\Profile\Middleware\Parameters\EditPersonalParameters;
use Domain\Profile\Repository\ProfileRepository;
use Domain\Profile\Image\ProfileImageStrategy;
use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;
use League\Flysystem\FilesystemInterface;

class ProfileService
{
    const EVENT_PROFILE_ACCESS = 'domain.profile.access';
    const EVENT_PROFILE_CREATED = 'domain.profile.create';
    const EVENT_PROFILE_UPDATED = 'domain.profile.update';
    const EVENT_PROFILE_DELETE = 'domain.profile.delete';
    const EVENT_PROFILE_DELETED = 'domain.profile.deleted';

    const MAX_PROFILES_PER_ACCOUNT = 10;

    /** @var EventEmitterInterface */
    private $events;

    /** @var ProfileRepository */
    private $profileRepository;

    /** @var AccountService */
    private $accountService;

    /** @var CollectionService */
    private $collectionService;

    /** @var FilesystemInterface */
    private $imagesFlySystem;

    /** @var AvatarService */
    private $avatarService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        ProfileRepository $profileRepository,
        CollectionService $collectionService,
        FilesystemInterface $imagesFlySystem,
        AvatarService $avatarService
    )
    {
        $this->events = new EventEmitter();
        $this->profileRepository = $profileRepository;
        $this->collectionService = $collectionService;
        $this->imagesFlySystem = $imagesFlySystem;
        $this->avatarService = $avatarService;
    }

    public function getEventEmitter(): EventEmitterInterface
    {
        return $this->events;
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
        $this->collectionService->createCollection(new CreateCollectionParameters(
            sprintf('profile:%d', $profile->getId()),
            '$gt_collection_my-feed_title',
            '$gt_collection_my-feed_description'
        ), true);
        $this->accountService->switchToProfile($account, $profile->getId());

        $this->generateProfileImage($profile->getId());
        $this->events->emit(self::EVENT_PROFILE_CREATED, [$profile]);

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

        $this->profileRepository->saveProfile($profile);
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile;
    }

    public function deleteProfile(int $profileId): Profile
    {
        $profile = $this->getProfileById($profileId);
        $account = $profile->getAccount();

        if ($account->getProfiles()->count() === 1) {
            throw new LastProfileException('This is your last profile. Sorry you need at least one profile per account.');
        }

        $this->events->emit(self::EVENT_PROFILE_DELETE, [$profile]);
        $this->profileRepository->deleteProfile($profile);
        $account->getProfiles()->removeElement($profile);

        if ($profile->isCurrent()) {
            $firstProfile =  $account->getProfiles()->first(); /** @var Profile $firstProfile */
            $this->accountService->switchToProfile($account, $firstProfile->getId());
        }

        $this->events->emit(self::EVENT_PROFILE_DELETED, [$profile]);

        return $account->getCurrentProfile();
    }

    public function setGreetings(int $profileId, Greetings $greetings): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setGreetings($greetings);

        $this->profileRepository->saveProfile($profile);
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile;
    }

    public function setGender(int $profileId, Gender $gender): Gender
    {
        $profile = $this->getProfileById($profileId);
        $profile->setGender($gender);

        $this->profileRepository->saveProfile($profile);
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getGender();
    }

    public function uploadImage(int $profileId, UploadImageParameters $parameters): ImageCollection
    {
        $profile = $this->getProfileById($profileId);
        $strategy = new ProfileImageStrategy($profile, $this->imagesFlySystem);

        $this->avatarService->uploadImage($strategy, $parameters);
        $this->profileRepository->saveProfile($profile);
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getImages();
    }

    public function deleteProfileImage(int $profileId): ImageCollection
    {
        $profile = $this->getProfileById($profileId);

        $this->generateProfileImage($profileId);
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getImages();
    }

    private function generateProfileImage(int $profileId): ImageCollection
    {
        $profile = $this->getProfileById($profileId);
        $strategy = new ProfileImageStrategy($profile, $this->imagesFlySystem);

        $this->avatarService->generateImage($strategy);
        $this->profileRepository->saveProfile($profile);

        return $profile->getImages();
    }

    public function setInterestingInThemes(int $profileId, array $themeIds): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setInterestingInIds($themeIds);

        $this->profileRepository->saveProfile($profile);
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile;
    }

    public function setExpertsInThemes(int $profileId, array $themeIds): Profile
    {
        $profile = $this->getProfileById($profileId);
        $profile->setExpertInIds($themeIds);

        $this->profileRepository->saveProfile($profile);
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

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
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

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
        $this->events->emit(self::EVENT_PROFILE_UPDATED, [$profile]);

        return $profile->getCollections();
    }
}