<?php
namespace CASS\Chat\Bundles\Contact\Service;

use CASS\Chat\Bundles\Contact\Entity\Contact;
use CASS\Chat\Bundles\Contact\Repository\ContactRepository;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Util\Seek;

class ContactService implements IContactService
{
    /** @var ContactRepository  */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getContacts(Profile $profile, Seek $seek)
    {
        return $this->contactRepository->findBy([
            'profileId' => $profile->getId()
        ],null, $seek->getLimit(), $seek->getOffset());
    }

    public function addContact(Profile $profile, Profile $contact): Contact
    {
        $newContact = new Contact();
        $newContact->setContactProfileId($contact->getId());
        $newContact->setProfileId($profile->getId());
        
        return $this->contactRepository->saveContact($newContact);
    }

    

}