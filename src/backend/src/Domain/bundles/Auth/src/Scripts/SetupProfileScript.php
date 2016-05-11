<?php


namespace Domain\Auth\Scripts\SetupProfile;



use Domain\Profile\Entity\ProfileGreetings;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class SetupProfileScript
{
  /** @var ResourceOwnerInterface  */
  protected $resourceOwner;
  /** @var ProfileGreetings  */
  protected $greetings;

  public function getResourceOwner()
  {
    return $this->resourceOwner;
  }

  public function getGreetings():ProfileGreetings
  {
    return $this->greetings;
  }

  public function __construct($resourceOwner, $greetings){
    $this->greetings = $greetings;
    $this->resourceOwner = $resourceOwner;
  }

  public function fetchProfileGreetings():ProfileGreetings{


    $resource_type = $this->resourceOwner;

    switch($resource_type){
      case 'google':
        return GoogleSetupProfileScript::getGreetings($this);

    }
  }
}