<?php
namespace Profile\Entity;

/**
 * @Entity(repositoryClass="Profile\Repository\ProfileRepository")
 * @Table(name="profile")
 */
class Profile
{
    /**
     * @var int
     * @Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @Column(type="integer")
     */
    private $accountId;

    /**
     * @var bool
     * @Column(type="integer",name="is_current")
     */
    private $isCurrent;

    /**
     * @OneToOne(targetEntity="Profile\Entity\ProfileGreetings")
     * @JoinColumn(name="profile_greetings_id", referencedColumnName="id")
     * @var ProfileGreetings
     */
    private $profileGreetings;

    /**
     * @OneToOne(targetEntity="Profile\Entity\ProfileImage")
     * @JoinColumn(name="profile_image_id", referencedColumnName="id")
     * @var ProfileImage
     */
    private $profileImage;

    public function __construct(int $accountId)
    {
        $this->accountId = $accountId;
    }

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
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

    public function getProfileGreetings(): ProfileGreetings
    {
        return $this->profileGreetings;
    }

    public function setProfileGreetings(ProfileGreetings $profileGreetings): self
    {
        $this->profileGreetings = $profileGreetings;

        return $this;
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