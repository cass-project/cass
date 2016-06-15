<?php


namespace Domain\PostReport\Parameters;


class CreatePostReportParameters
{
  protected $profileId;
  protected $createdAt;
  protected $reportTypes;
  protected $description;

  public function __construct(int $profileId, array $reportTypes = null, string $description)
  {
    $this->profileId   = $profileId;
    $this->createdAt   = new \DateTime();
    $this->reportTypes = $reportTypes;
    $this->description = $description;
  }

  public function getProfileId():int
  {
    return $this->profileId;
  }

  public function getCreatedAt():\DateTime
  {
    return $this->createdAt;
  }

  public function getReportTypes()
  {
    return $this->reportTypes;
  }

  public function getDescription():string
  {
    return $this->description;
  }

}