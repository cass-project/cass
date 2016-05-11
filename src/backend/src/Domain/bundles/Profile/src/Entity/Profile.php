<?php
namespace Domain\Profile\Entity;

use Application\Util\IdTrait;
use Application\Util\JSONSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Domain\Account\Entity\Account;
use Domain\Collection\Collection\CollectionTree;
use Domain\Collection\Traits\CollectionOwnerTrait;
use Domain\Theme\Entity\Theme;
use Domain\Profile\Exception\UnknownGenderException;

/**
 * @Entity(repositoryClass="Domain\Profile\Repository\ProfileRepository")
 * @Table(name="profile")
 */
class Profile implements JSONSerializable
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;

    use IdTrait;
    use CollectionOwnerTrait;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $gender;

    /**
     * @Column(type="boolean", name="is_initialized")
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @ManyToOne(targetEntity="Domain\Account\Entity\Account")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @var bool
     * @Column(type="integer",name="is_current")
     */
    private $isCurrent = false;

    /**
     * @OneToOne(targetEntity="Domain\Profile\Entity\ProfileGreetings", mappedBy="profile", cascade={"persist", "remove"})
     * @var ProfileGreetings
     */
    private $profileGreetings;

    /**
     * @OneToOne(targetEntity="Domain\Profile\Entity\ProfileImage", mappedBy="profile", cascade={"persist", "remove"})
     * @var ProfileImage
     */
    private $profileImage;

    /**
     * @ManyToMany(targetEntity="Domain\Theme\Entity\Theme")
     * @JoinTable(
     *      name="profile_expert_in",
     *      joinColumns={@JoinColumn(name="profile_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="theme_id", referencedColumnName="id", unique=true)}
     * )
     * @var ArrayCollection
     */
    private $expert_in = [];

    /**
     * @ManyToMany(targetEntity="Domain\Theme\Entity\Theme")
     * @JoinTable(
     *     name="profile_interesting_in",
     *     joinColumns={@JoinColumn(name="profile_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="theme_id", referencedColumnName="id", unique=true)}
     * )
     * @var ArrayCollection
     */
    private $interesting_in = [];

    /**
     * @var string
     * @Column(type="string",name="expert_in_ids")
     */
    private $expert_in_ids;

    /**
     * @var string
     * @Column(type="string",name="interesting_in_ids")
     */
    private $interesting_in_ids;

    public function toJSON(): array {
        return [
            'id' => (int)$this->getId(),
            'account_id' => (int)$this->getAccount()->getId(),
            'current' => (bool)$this->isCurrent(),
            'is_initialized' => $this->isInitialized(),
            'greetings' => $this->getProfileGreetings()->toJSON(),
            'image' => $this->getProfileImage()->toJSON(),
            'expert_in' => array_map(function (Theme $theme) {
                return $theme->getId();
            }, $this->expert_in->toArray()),
            'interesting_in' => array_map(function (Theme $theme) {
                return $theme->getId();
            }, $this->interesting_in->toArray()),
            'collections' => $this->collections->toJSON()
        ];
    }

    public function __construct(Account $account) {
        $this->account = $account;
        $this->expert_in = new ArrayCollection();
        $this->interesting_in = new ArrayCollection();
        $this->collections = new CollectionTree();
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender(int $gender): self {
        if (!in_array($gender, [self::GENDER_FEMALE, self::GENDER_MALE]))
            throw new UnknownGenderException("the gender: %s is unknown", $gender);

        $this->gender = $gender;
        return $this;
    }

    public function getExpertIn() {
        return $this->expert_in;
    }

    public function setExpertIn(array $expertIn): self {
        $this->expert_in = $expertIn;
        return $this;
    }

    public function getExpertInIds(): string {
        return $this->expert_in_ids;
    }

    public function setExpertInIds(array $expertInIds): self {
        $expertInIds = array_map(function (Theme $theme) {
            return $theme->getId();
        }, $expertInIds);

        $this->expert_in_ids = json_encode($expertInIds);
        return $this;
    }

    public function getInterestingInIds(): string {
        return $this->interesting_in_ids;
    }

    public function setInterestingInIds(array $interestingInIds): self {
        $interestingInIds = array_map(function (Theme $theme) {
            return $theme->getId();
        }, $interestingInIds);

        $this->interesting_in_ids = json_encode($interestingInIds);
        return $this;
    }

    public function getInterestingIn() {
        return $this->interesting_in;
    }

    public function setInterestingIn(array $interestingIn): self {
        $this->interesting_in = $interestingIn;
        return $this;
    }

    public function isInitialized(): bool {
        return (bool)$this->isInitialized;
    }

    public function setAsInitialized(): self {
        $this->isInitialized = true;

        return $this;
    }


    public function setAccount(Account $account)
    {
        $this->account = $account;
        return $this;
    }
    public function getAccount(): Account {
        return $this->account;
    }

    public function isCurrent(): bool {
        return $this->isCurrent;
    }

    public function setIsCurrent(bool $isCurrent): self {
        $this->isCurrent = $isCurrent;

        return $this;
    }

    public function hasProfileGreetings(): bool {
        return $this->profileGreetings !== null;
    }

    public function getProfileGreetings(): ProfileGreetings {
        return $this->profileGreetings;
    }

    public function setProfileGreetings(ProfileGreetings $profileGreetings): self {
        $this->profileGreetings = $profileGreetings;

        return $this;
    }

    public function hasProfileImage(): bool {
        return $this->profileImage !== null;
    }

    public function getProfileImage(): ProfileImage {
        return $this->profileImage;
    }

    public function setProfileImage(ProfileImage $profileImage): self {
        $this->profileImage = $profileImage;

        return $this;
    }
}