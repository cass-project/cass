<?php
namespace Domain\PostReport\Entity;

use Application\Util\IdTrait;
use Domain\Profile\Entity\Profile;
/**
 * @Entity(repositoryClass="Domain\PostReport\Repository\PostReportRepository")
 * @Table(name="post_report")
 */
class PostReport
{
  use IdTrait;

  /** Нецензурная лексика */
  const TypeCensored = 1;
  /** Оскорбление, Дискриминация, некорректное поведение */
  const TypeBadBehavior = 2;
  /** Не относящийся к тематике контент */
  const TypeOfftop = 3;
  /** Запрещённый контент */
  const TypeBanContent = 4;
  /** Другое */
  const TypeOther = 5;

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

  public function getProfile():Profile
  {
    return $this->profile;
  }

  public function setProfile(Profile $profile):self
  {
    $this->profile = $profile;
    return $this;
  }

  public function getCreatedAt():\DateTime{
    return $this->created_at;
  }

  public function setCreatedAt(\DateTime $created_at):self
  {
    $this->created_at = $created_at;
    return $this;
  }

  public function getReportTypes():array
  {
    return json_decode($this->report_types, true);
  }

  public function setReportTypes(array $report_types):self
  {
    $this->report_types = json_encode($report_types) ;
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