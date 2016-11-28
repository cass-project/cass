<?php
namespace CASS\Domain\Bundles\Profile\Service;

use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Entity\Card\ProfileCard;
use CASS\Domain\Bundles\Profile\Entity\Card\Values\ProfileCardValue;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Repository\ProfileRepository;
use Cocur\Chain\Chain;

final class ProfileCardService
{
    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function createInitialProfileCard(Profile $profile): ProfileCard
    {
        $card = new ProfileCard();
        $card->getAccessManager()
            ->setAccess('profile.first_name', ProfileCardAccess::ACCESS_PUBLIC)
            ->setAccess('profile.last_name', ProfileCardAccess::ACCESS_PUBLIC)
            ->setAccess('profile.middle_name', ProfileCardAccess::ACCESS_PUBLIC)
            ->setAccess('profile.gender', ProfileCardAccess::ACCESS_PUBLIC)
            ->setAccess('profile.interesting_in', ProfileCardAccess::ACCESS_PUBLIC)
            ->setAccess('profile.expert_in', ProfileCardAccess::ACCESS_PUBLIC)
            ->setAccess('profile.contacts.email', ProfileCardAccess::ACCESS_PRIVATE)
        ;

        return $card;
    }

    public function saveProfileCard(Profile $profile, ProfileCard $profileCard)
    {
        $profile->replaceCard($profileCard);

        $this->profileRepository->saveProfile($profile);
    }

    public function importProfileCard(Profile $profile, ProfileCard $copyCard): ProfileCard
    {
        $manager = $copyCard->getValuesManager();

        array_map(function(ProfileCardAccess $access) use ($profile) {
            $profile->getCard()->getAccessManager()->setAccess(
                $access->getKey(), $access->getAccessLevel()
            );
        }, $copyCard->getAccessManager()->getAll());

        $greetings = clone $profile->getGreetings();

        array_map(function(ProfileCardValue $profileCardValue) use ($profile, $manager, $copyCard, $greetings) {
            $key = $profileCardValue->getKey();
            $value = $profileCardValue->getValue();

            switch($key) {
                default:
                    $profile->getCard()->getValuesManager()->setValue($key, $value);
                    break;

                case 'profile.first_name':
                    $greetings->setFirstName($value);
                    break;

                case 'profile.last_name':
                    $greetings->setLastName($value);
                    break;

                case 'profile.middle_name':
                    $greetings->setMiddleName($value);
                    break;

                case 'profile.gender':
                    $profile->setGender(Profile\Gender\Gender::createFromStringCode($value));
                    break;

                case 'profile.interesting_in':
                    $profile->setInterestingInIds($value);
                    break;

                case 'profile.expert_in':
                    $profile->setExpertInIds($value);
                    break;
            }
        }, $copyCard->getValuesManager()->getAll());

        $profile->setGreetings($greetings);

        $this->saveProfileCard($profile, $profile->getCard());

        return $this->exportProfileCard($profile, [
            ProfileCardAccess::ACCESS_PUBLIC,
            ProfileCardAccess::ACCESS_PRIVATE,
            ProfileCardAccess::ACCESS_PROTECTED,
        ]);
    }

    public function exportProfileCard(Profile $sourceProfile, array $accessLevel): ProfileCard
    {
        $sourceCard = $sourceProfile->getCard();
        $copyCard = new ProfileCard(
            array_map(function(ProfileCardAccess $access) { return clone $access; }, $sourceCard->getAccessManager()->getAll()),
            []
        );

        $allowedFields = Chain::create($sourceCard->getAccessManager()->getAll())
            ->filter(function(ProfileCardAccess $fieldAccess) use ($accessLevel) {
                return in_array($fieldAccess->getAccessLevel(), $accessLevel);
            })
            ->map(function(ProfileCardAccess $fieldAccess) use ($accessLevel) {
                return $fieldAccess->getKey();
            })
            ->array;

        foreach($allowedFields as $field) {
            switch($field) {
                default:
                    $copyCard->getValuesManager()->setValue($field, $sourceCard->getValuesManager()->getValue($field)->getValue());
                    break;

                case 'profile.first_name':
                    $copyCard->getValuesManager()->setValue($field, $sourceProfile->getGreetings()->getFirstName());
                    break;

                case 'profile.last_name':
                    $copyCard->getValuesManager()->setValue($field, $sourceProfile->getGreetings()->getLastName());
                    break;

                case 'profile.middle_name':
                    $copyCard->getValuesManager()->setValue($field, $sourceProfile->getGreetings()->getMiddleName());
                    break;

                case 'profile.gender':
                    $copyCard->getValuesManager()->setValue($field, $sourceProfile->getGender()->getStringCode());
                    break;

                case 'profile.interesting_in':
                    $copyCard->getValuesManager()->setValue($field, $sourceProfile->getInterestingInIds());
                    break;

                case 'profile.expert_in':
                    $copyCard->getValuesManager()->setValue($field, $sourceProfile->getExpertInIds());
                    break;

                case 'profile.contacts.email':
                    $copyCard->getValuesManager()->setValue($field, $sourceProfile->getAccount()->getEmail());
                    break;
            }
        }

        return $copyCard;
    }

    public function resoluteAccessLevel(Profile $sourceProfile, Profile $viewer): array
    {
        if($sourceProfile->getId() === $viewer->getId()) {
            return [ProfileCardAccess::ACCESS_PRIVATE, ProfileCardAccess::ACCESS_PROTECTED, ProfileCardAccess::ACCESS_PUBLIC];
        }else if($sourceProfile->getAccount()->getId() === $viewer->getAccount()->getId()) {
            return [ProfileCardAccess::ACCESS_PROTECTED, ProfileCardAccess::ACCESS_PUBLIC];
        }else{
            return [ProfileCardAccess::ACCESS_PUBLIC];
        }
    }
}