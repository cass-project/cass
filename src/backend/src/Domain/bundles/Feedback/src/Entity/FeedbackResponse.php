<?php
namespace Domain\Feedback\Entity;

use Application\Util\IdTrait;
/**
 * @Entity(repositoryClass="Domain\Feedback\Repository\FeedbackResponseRepository")
 * @Table(name="feedback_response")
 */
class FeedbackResponse
{
  use IdTrait;

  /**
   * @ManyToOne(targetEntity="Domain\Feedback\Entity\Feedback", inversedBy="responses")
   * @JoinColumn(name="feedback_id", referencedColumnName="id")
   */
  private $feedback;

  /**
   * @Column(type="datetime")
   * @var string
   */
  private $created_at;

  /**
   * @Column(type="string")
   * @var string
   */
  private $description;

  public function getCreatedAt():\DateTime
  {
    return $this->created_at;
  }

  public function setCreatedAt(\DateTime $created_at):self
  {
    $this->created_at = $created_at;
    return $this;
  }

  public function getDescription():string
  {
    return $this->description;
  }

  public function setDescription(string $description):self
  {
    $this->description = $description;
    return $this;
  }

  public function getFeedback():Feedback
  {
    return $this->feedback;
  }

  public function setFeedback(Feedback $feedback):self
  {
    $this->feedback = $feedback;
    return $this;
  }

  public function toJSON():array
  {
    return [
      'id'          => $this->getId(),
      'feedback_id' => $this->getFeedback()->getId(),
      'created_at'  => $this->getCreatedAt(),
      'description' => $this->getDescription()
    ];
  }

}