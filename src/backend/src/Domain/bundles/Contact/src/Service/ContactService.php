<?php
namespace CASS\Domain\Bundles\Contact\Service;

use CASS\Domain\Bundles\Contact\Entity\Contact;
use CASS\Domain\Bundles\Contact\Exception\DuplicateContactException;
use CASS\Domain\Bundles\Contact\Parameters\CreateContactParameters;
use CASS\Domain\Bundles\Contact\Repository\ContactRepository;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

final class ContactService
{
    /** @var ContactRepository */
    private $contactRepository;

    /** @var ProfileService */
    private $profileService;

    public function __construct(
        ContactRepository $contactRepository,
        ProfileService $profileService
    ) {
        $this->contactRepository = $contactRepository;
        $this->profileService = $profileService;
    }

    public function createContact(Profile $sourceProfile, CreateContactParameters $parameters): Contact
    {
        $targetProfileId = $parameters->getProfileId();

        if($this->contactRepository->hasContact($sourceProfile->getId(), $targetProfileId)) {
            throw new DuplicateContactException(sprintf('Contact with Profile(id:%s) already exists', $targetProfileId));
        }

        $contact = new Contact($sourceProfile, $this->profileService->getProfileById($targetProfileId));
        $contact->setPermanent();

        $this->contactRepository->createContact($contact);

        return $contact;
    }

    public function setPermanentContact(int $contactId): Contact
    {
        $contact = $this->getContactById($contactId);
        $contact->setPermanent();

        $this->contactRepository->saveContact($contact);

        return $contact;
    }

    public function deleteContact(int $contactId)
    {
        $this->contactRepository->deleteContact(
            $this->getContactById($contactId)
        );
    }

    public function listContacts(Profile $sourceProfile)
    {
        return $this->contactRepository->getBySource($sourceProfile->getId());
    }

    public function getContactById(int $contactId): Contact
    {
        return $this->contactRepository->getById($contactId);
    }

    public function getContactsByIds(array $contactIds): array
    {
        return $this->contactRepository->getByIds($contactIds);
    }
}