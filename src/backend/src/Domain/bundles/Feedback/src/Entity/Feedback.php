<?php

namespace Domain\Feedback\Entity;
use Application\Util\IdTrait;
use Domain\Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="Domain\Feedback\Repository\FeedbackRepository")
 * @Table(name="feedback")
 */
class Feedback
{
  const TYPE_COMMON_QUESTIONS = 1;
  const TYPE_REQUEST_ADD_THEMATIC = 2;
  const TYPE_SUGGESTIONS = 3;

  use IdTrait;


  /**
   * @Column(type="datetime")
   * @var string
   */
  private $created_at;
  /**
   * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
   * @JoinColumn(name="profile_id", referencedColumnName="id")
   */
  private $profile;

  /**
   * @Column(type="integer")
   * @var int
   */
  private $type;

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

  public function getProfile()
  {
    return $this->profile;
  }

  public function hasProfile()
  {
    return $this->getProfile() !== NULL;
  }

  public function setProfile(Profile $profile = null):self
  {
    $this->profile = $profile;
    return $this;
  }

  public function getType():int{
    return $this->type;
  }

  public function setType(int $type):self
  {
    $this->type = $type;
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

  public function toJSON():array
  {
    return [
      'id'          => $this->id,
      'created_at'  => $this->created_at,
      'description' => $this->description,
      'profile_id'  => $this->hasProfile() ? $this->hasProfile()->getId() : NULL,
      'type'        => $this->type
    ];
  }

}