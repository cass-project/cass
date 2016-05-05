<?php
namespace Profile\Entity;
use Common\REST\JSONSerializable;
use Common\Util\IdTrait;

/**
 * @Entity(repositoryClass="Profile\Repository\ProfileGreetingsRepository")
 * @Table(name="profile_greetings")
 */
class ProfileGreetings implements JSONSerializable
{
    const GREETINGS_FL = 'fl';
    const GREETINGS_LFM = 'lfm';
    const GREETINGS_N = 'n';

    const AVAILABLE_GREETINGS = [
        self::GREETINGS_FL,
        self::GREETINGS_LFM,
        self::GREETINGS_N
    ];

    use IdTrait;

    /**
     * @OneToOne(targetEntity="Profile\Entity\Profile", inversedBy="profileGreetings")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @Column(type="string",name="greetings_method")
     * @var string
     */
    private $greetingsMethod = self::GREETINGS_FL;

    /**
     * @Column(type="string",name="first_name")
     * @var string
     */
    private $firstName;

    /**
     * @Column(type="string",name="last_name")
     * @var string
     */
    private $lastName;

    /**
     * @Column(type="string",name="middle_name")
     * @var string
     */
    private $middleName;

    /**
     * @Column(type="string",name="nick_name")
     * @var string
     */
    private $nickName;

    public function __construct(Profile $profile)
    {
        $this->profile = $profile;
        $this->profile->setProfileGreetings($this);
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'profile_id' => $this->getProfile()->getId(),
            'greetings_method' => $this->getGreetingsMethod(),
            'greetings' => $this->getGreetings(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'middle_name' => $this->getMiddleName(),
            'nickname' => $this->getNickName()
        ];
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function nameFL(string $firstName, string $lastName)
    {
        $this->greetingsMethod = 'fl';
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function nameLFM(string $firstName, string $lastName, string $middleName)
    {
        $this->greetingsMethod = 'lfm';
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->middleName = $middleName;
    }

    public function nameN(string $nickName)
    {
        $this->greetingsMethod = 'n';
        $this->nickName = $nickName;
    }

    public function getGreetingsMethod(): string
    {
        return $this->greetingsMethod;
    }

    public function getGreetings(): string
    {
        switch($this->greetingsMethod) {
            default:
                return $this->getProfile()->getAccount()->getEmail();
            case self::GREETINGS_FL:
                return sprintf('%s %s', $this->getFirstName(), $this->getLastName());
            case self::GREETINGS_LFM:
                return sprintf('%s %s %s', $this->getLastName(), $this->getFirstName(), $this->getMiddleName());
            case self::GREETINGS_N:
                return $this->getNickName();
        }
    }

    public function setGreetingsMethod(string $greetingsMethod): self
    {
        $this->greetingsMethod = $greetingsMethod;

        return $this;
    }

    public function getFirstName(): string
    {
        return (string) $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return (string) $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): string
    {
        return (string) $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getNickName(): string
    {
        return (string) $this->nickName;
    }

    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }
}