<?php
namespace Domain\PostReport\Entity;

use Domain\Profile\Entity\Profile;

class PostReport
{
  /** Нецензурная лексика */
  const TypeCensored = 1;
  /** Оскорбление, Дискриминация, некорректное поведение */
  const Type = 2;
  /** Не относящийся к тематике контент */
  const POST_OFFTOP = 3;
  /** Не относящийся к тематике контент */
  const POST_REPORT_TYPE_4 = 3;

  /**
   * @Column(type="integer")
   * @var int
   */
  protected $id;

  /**
   * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
   * @JoinColumn(name="profile_id", referencedColumnName="id")
   */
  protected $profile;
  /**
   * @Column(type="datetime")
   * @var string
   */
  protected $created_at;

  /**
   * @Column(type="text")
   * @var string
   */
  protected $report_types;
  /**
   * @Column(type="text")
   * @var string
   */
  protected $description;

  public function getId():int
  {
    return $this->id;
  }

  public function setId($id):self
  {
    $this->id = $id;
    return $this;
  }

  public function getProfile():Profile
  {
    return $this->profile;
  }

  public function setProfile(Profile $profile):self
  {
    $this->profile = $profile;
    return $this;
  }

  public function getCreatedAt(){
    return $this->created_at;
  }

  public function setCreatedAt($created_at):self
  {
    $this->created_at = $created_at;
    return $this;
  }

  public function getReportTypes()
  {
    return $this->report_types;
  }

  public function setReportTypes($report_types):self
  {
    $this->report_types = $report_types;
    return $this;
  }

  public function getDescription():string
  {
    return $this->description;
  }

  public function setDescription($description):self
  {
    $this->description = $description;
    return $this;
  }

  public function toJSON():array
  {
    return [
      'id'           => $this->id,
      'profile_id'   => $this->getProfile()->getId(),
      'created_at'   => $this->created_at,
      'report_types' => $this->report_types,
      'description'  => $this->description
    ];
  }
}