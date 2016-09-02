<?php


namespace CASS\Domain\Auth\Scripts;

use CASS\Domain\Profile\Entity\ProfileGreetings;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class SetupProfileScript
{
  /** @var ResourceOwnerInterface  */
  protected $resourceOwner;
  /** @var ProfileGreetings  */
  protected $greetings;

  protected $provider;

  public function getResourceOwner()
  {
    return $this->resourceOwner;
  }

  public function getGreetings():ProfileGreetings
  {
    return $this->greetings;
  }

  public function __construct($provider, ResourceOwnerInterface $resourceOwner,ProfileGreetings $greetings){
    $this->provider = $provider;
    $this->greetings = $greetings;
    $this->resourceOwner = $resourceOwner;
  }

  public function fetchProfileGreetings():ProfileGreetings{

    switch($this->provider ){
      case 'google':
        return GoogleSetupProfileScript::getGreetings($this);

    }
  }
}