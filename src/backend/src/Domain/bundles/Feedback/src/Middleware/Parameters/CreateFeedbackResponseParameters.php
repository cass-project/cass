<?php


namespace Domain\Feedback\Middleware\Parameters;


class CreateFeedbackResponseParameters
{
  private $feedbackId;
  private $createdAt;
  private $description;

  public function __construct( $description, $feedbackId)
  {
    $this->createdAt = new \DateTime();
    $this->feedbackId   = $feedbackId;
    $this->description = $description;
  }

  public function getFeedbackId():int
  {
    return $this->feedbackId;
  }

  public function getCreatedAt():\DateTime{
    return $this->createdAt;
  }


  public function getDescription():string{
    return $this->description;
  }


}