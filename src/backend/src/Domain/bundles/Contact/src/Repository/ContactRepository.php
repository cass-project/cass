<?php
namespace Domain\Contact\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Contact\Entity\Contact;
use Domain\Contact\Exception\ContactNotFoundException;

final class ContactRepository extends EntityRepository
{
    public function createContact(Contact $contact)
    {
        $this->getEntityManager()->persist($contact);
        $this->getEntityManager()->flush($contact);
    }

    public function saveContact(Contact $contact)
    {
        $this->getEntityManager()->flush($contact);
    }
    
    public function deleteContact(Contact $contact)
    {
        $this->getEntityManager()->remove($contact);
        $this->getEntityManager()->flush($contact);
    }

    public function hasContact(int $sourceProfileId, int $targetProfileId): bool
    {
        return $this->findOneBy([
            'sourceProfile' => $sourceProfileId,
            'targetProfile' => $targetProfileId,
        ]) !== null;
    }
    
    public function getById(int $contactId): Contact
    {
        $result = $this->find($contactId);

        if($result === null) {
            throw new ContactNotFoundException(sprintf('Contact(id: %s) not found', $contactId));
        }

        return $result;
    }
    
    public function getByIds(array $contactIds): array
    {
        /** @var Contact[] $result */
        $result = $this->findBy(['id' => array_filter($contactIds, function($input) {
            return is_int($input);
        })]);
        
        if(count($result) !== count($contactIds)) {
            throw new ContactNotFoundException(sprintf('One or more contacts not found, requested `%s`', json_encode($contactIds)));
        }

        return $result;
    }

    public function getBySource(int $sourceProfileId)
    {
        /** @var Contact[] $result */
        $result = $this->findBy([
            'sourceProfile' => $sourceProfileId
        ]);

        return $result;
    }
}