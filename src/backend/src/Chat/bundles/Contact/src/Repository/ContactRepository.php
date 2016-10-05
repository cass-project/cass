<?php
namespace CASS\Chat\Bundles\Contact\Repository;

use CASS\Chat\Bundles\Contact\Entity\Contact;
use Doctrine\ORM\EntityRepository;

class ContactRepository extends EntityRepository
{
    public function saveContact(Contact $contact): Contact
    {
        $em = $this->getEntityManager();
        
        $em->persist($contact);
        $em->flush();

        return $contact;
    }
}