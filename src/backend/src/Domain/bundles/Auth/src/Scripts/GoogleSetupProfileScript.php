<?php


namespace CASS\Domain\Auth\Scripts;


use CASS\Domain\Profile\Entity\ProfileGreetings;
use League\OAuth2\Client\Provider\GoogleUser;

class GoogleSetupProfileScript
{
  public static function getGreetings(SetupProfileScript $profileScript):ProfileGreetings
  {
    /** @var GoogleUser $resourceOwner */
    $resourceOwner = $profileScript->getResourceOwner();

    return $profileScript->getGreetings()
             ->setFirstName($resourceOwner->getFirstName())
             ->setLastName($resourceOwner->getLastName());


  }
}