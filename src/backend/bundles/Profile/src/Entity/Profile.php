<?php
namespace Profile\Entity;
use Account\Entity\Account;
use Common\REST\JSONSerializable;

/**
 * @Entity(repositoryClass="Profile\Repository\ProfileRepository")
 * @Table(name="profile")
 */
class Profile implements JSONSerializable
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="boolean", name="is_initialized")
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @ManyToOne(targetEntity="Account\Entity\Account")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @var bool
     * @Column(type="integer",name="is_current")
     */
    private $isCurrent = false;

    /**
     * @OneToOne(targetEntity="Profile\Entity\ProfileGreetings", mappedBy="profile", cascade={"persist", "remove"})
     * @var ProfileGreetings
     */
    private $profileGreetings;

    /**
     * @OneToOne(targetEntity="Profile\Entity\ProfileImage", mappedBy="profile", cascade={"persist", "remove"})
     * @var ProfileImage
     */
    private $profileImage;




    private $expert_in = [];
    private $interesting_in = [];

    /**
     * @var string
     * @Column(type="string",name="expert_in_ids")
     */
    private $expert_in_ids;

    /**
     * @var string
     * @Column(type="string",name="interesting_in_str")
     */
    private $interesting_in_str;




    public function toJSON(): array
    {
        return [
          'id'              => (int) $this->getId(),
          'account_id'      => (int) $this->getAccount()->getId(),
          'current'         => (bool) $this->isCurrent(),
          'is_initialized'  => $this->isInitialized(),
          'greetings'       => $this->getProfileGreetings()->toJSON(),
          'image'           => $this->getProfileImage()->toJSON(),
          'expert_in_ids'       => json_encode($this->expert_in_ids),
          'intersting_in_str'   => json_encode($this->interesting_in_str)
        ];
    }

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @return string
     */
    public function getInterestingInStr(){
        return $this->interesting_in_str;
    }

    /**
     * @param string $interesting_in_str
     */
    public function setInterestingInStr($interesting_in_str){
        $this->interesting_in_str = $interesting_in_str;
    }

    /**
     * @return string
     */
    public function getExpertInIds(){
        return $this->expert_in_ids;
    }

    /**
     * @param string $expert_in_ids
     */
    public function setExpertInIds($expert_in_ids){
        $this->expert_in_ids = $expert_in_ids;
    }

    /**
     * @return array
     */
    public function getInterestingIn(){
        return $this->interesting_in;
    }

    /**
     * @param array $interesting_in
     */
    public function setInterestingIn($interesting_in){
        $this->interesting_in = $interesting_in;
    }

    /**
     * @return array
     */
    public function getExpertIn(){
        return $this->expert_in;
    }

    /**
     * @param array $expert_in
     */
    public function setExpertIn($expert_in){
        $this->expert_in = $expert_in;
    }



    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isInitialized(): bool
    {
        return (bool) $this->isInitialized;
    }

    public function setAsInitialized(): self
    {
        $this->isInitialized = true;

        return $this;
    }

    public function getAccount(): \Account\Entity\Account
    {
        return $this->account;
    }

    public function isCurrent(): bool
    {
        return $this->isCurrent;
    }

    public function setIsCurrent(bool $isCurrent): self
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }

    public function hasProfileGreetings(): bool
    {
        return $this->profileGreetings !== null;
    }

    public function getProfileGreetings(): ProfileGreetings
    {
        return $this->profileGreetings;
    }

    public function setProfileGreetings(ProfileGreetings $profileGreetings): self
    {
        $this->profileGreetings = $profileGreetings;

        return $this;
    }

    public function hasProfileImage(): bool
    {
        return $this->profileImage !== null;
    }

    public function getProfileImage(): ProfileImage
    {
        return $this->profileImage;
    }

    public function setProfileImage(ProfileImage $profileImage): self
    {
        $this->profileImage = $profileImage;

        return $this;
    }
}