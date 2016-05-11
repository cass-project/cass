<?php
namespace Domain\Profile\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Profile\Entity\ProfileGreetings;

class ProfileGreetingsRepository extends EntityRepository
{
  public function saveGreetings(ProfileGreetings $greetings)
  {
    $em = $this->getEntityManager();
    $em->persist($greetings);
    $em->flush([$greetings]);
  }
}