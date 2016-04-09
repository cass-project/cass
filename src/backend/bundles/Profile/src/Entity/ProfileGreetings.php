<?php
namespace Profile\Entity;

/**
 * @Entity(repositoryClass="Profile\Repository\ProfileGreetingsRepository")
 * @Table(name="profile_greetings")
 */
class ProfileGreetings
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     * @var int
     */
    private $id;

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
    private $greetingsMethod = 'fl';

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

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
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

    public function setGreetingsMethod(string $greetingsMethod): self
    {
        $this->greetingsMethod = $greetingsMethod;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getNickName(): string
    {
        return $this->nickName;
    }

    public function setNickName(string $nickName): self
    {
        $this->nickName = $nickName;

        return $this;
    }
}