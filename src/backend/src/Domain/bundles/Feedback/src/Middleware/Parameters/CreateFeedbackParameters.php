<?php
namespace Domain\Feedback\Middleware\Parameters;


class CreateFeedbackParameters
{
  private $createdAt;
  private $profileId;
  private $type;
  private $description;

  public function __construct($type, $description, $profileId=null)
  {
    $this->createdAt = new \DateTime();
    $this->type        = $type;
    $this->profileId   = $profileId;
    $this->description = $description;
  }

  public function getCreatedAt():\DateTime{
    return $this->createdAt;
  }

  public function getProfileId(){
    return $this->profileId;
  }

  public function hasProfile()
  {
    return $this->profileId != null;
  }

  public function getType():int{
    return $this->type;
  }

  public function getDescription():string{
    return $this->description;
  }

  public function setProfileId(int $profileId):self
  {
    $this->profileId = $profileId;
    return $this;
  }
}