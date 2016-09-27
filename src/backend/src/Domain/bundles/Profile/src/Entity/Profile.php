<?php
namespace CASS\Domain\Bundles\Profile\Entity;

use CASS\Domain\Bundles\Backdrop\Entity\Backdrop;
use CASS\Domain\Bundles\Backdrop\Entity\Backdrop\NoneBackdrop;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAware;
use CASS\Domain\Bundles\Backdrop\Entity\BackdropEntityAwareTrait;
use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\Entity\SIDEntity\SIDEntity;
use CASS\Util\Entity\SIDEntity\SIDEntityTrait;
use CASS\Util\JSONSerializable;
use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Avatar\Entity\ImageEntity;
use CASS\Domain\Bundles\Avatar\Entity\ImageEntityTrait;
use CASS\Domain\Bundles\Avatar\Image\ImageCollection;
use CASS\Domain\Bundles\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use CASS\Domain\Bundles\Collection\Strategy\CollectionAwareEntity;
use CASS\Domain\Bundles\Collection\Strategy\Traits\CollectionAwareEntityTrait;;
use CASS\Domain\Bundles\Index\Entity\IndexedEntity;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\Gender;
use CASS\Domain\Bundles\Profile\Entity\Profile\Gender\GenderNotSpecified;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings\Greetings;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings\GreetingsAnonymous;
use CASS\Domain\Bundles\Profile\Exception\InvalidBirthdayException;
use CASS\Domain\Bundles\Profile\Exception\InvalidBirthdayGuestFromTheFutureException;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Profile\Repository\ProfileRepository")
 * @Table(name="profile")
 */
class Profile implements JSONSerializable, IdEntity, SIDEntity, ImageEntity, BackdropEntityAware, CollectionAwareEntity, IndexedEntity
{
    const MIN_AGE = 3;
    const MAX_AGE = 130;

    const EXCEPTION_GUEST_FUTURE = "Hello stranger, does nuclear war happen?";
    const EXCEPTION_YOUNG = "You're too young, where are your parents?";
    const EXCEPTION_OLD = "You're too old, where is your grave?";

    use IdTrait;
    use SIDEntityTrait;
    use CollectionAwareEntityTrait;
    use ImageEntityTrait;
    use BackdropEntityAwareTrait;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Account\Entity\Account")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @Column(type="boolean", name="is_initialized")
     * @var bool
     */
    private $isInitialized = false;

    /**
     * @var bool
     * @Column(type="integer", name="is_current")
     */
    private $isCurrent = false;

    /**
     * @Column(type="object", name="greetings")
     * @var Greetings
     */
    private $greetings;

    /**
     * @Column(type="integer")
     * @var int
     */
    private $gender;

    /**
     * @Column(type="datetime", name="birthday")
     * @var \DateTime|null
     */
    private $birthday;

    /**
     * @Column(type="json_array", name="interesting_in_ids")
     * @var int[]
     */
    private $interestingInIds = [];

    /**
     * @Column(type="json_array", name="expert_in_ids")
     * @var int[]
     */
    private $expertInIds = [];

    public function __construct(Account $account)
    {
        $this->account = $account;
        $this->collections = new ImmutableCollectionTree();
        $this->greetings = new GreetingsAnonymous();
        $this->gender = (new GenderNotSpecified())->getIntCode();
        $this->dateCreatedOn = new \DateTime();

        $this->regenerateSID();
        $this->setBackdrop(new NoneBackdrop());
        $this->setImages(new ImageCollection());
    }

    public function toJSON(): array
    {
        $result = [
            'id' => $this->isPersisted() ? $this->getId() : '#NEW_PROFILE',
            'sid' => $this->getSID(),
            'account_id' => $this->getAccount()->isPersisted()
                ? $this->getAccount()->getId()
                : '#NEW_ACCOUNT'
            ,
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'is_current' => (bool)$this->isCurrent(),
            'is_initialized' => $this->isInitialized(),
            'greetings' => $this->getGreetings()->toJSON(),
            'gender' => $this->getGender()->toJSON(),
            'image' => $this->getImages()->toJSON(),
            'backdrop' => $this->getBackdrop()->toJSON(),
            'expert_in_ids' => $this->expertInIds,
            'interesting_in_ids' => $this->interestingInIds,
            'collections' => $this->getCollections()->toJSON(),
        ];

        if($this->isBirthdaySpecified()) {
            $result['birthday'] = $this->getBirthday()->format(\DateTime::RFC2822);
        }

        return $result;
    }

    public function toIndexedEntityJSON(): array
    {
        return array_merge($this->toJSON(), [
            'date_created_on' => $this->getDateCreatedOn(),
        ]);
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAsInitialized(): self
    {
        $this->isInitialized = true;

        return $this;
    }

    public function isInitialized(): bool
    {
        return (bool)$this->isInitialized;
    }

    public function isCurrent(): bool
    {
        return $this->isCurrent;
    }

    public function setAsCurrent(): self
    {
        $this->isCurrent = true;

        return $this;
    }

    public function unsetAsCurrent(): self
    {
        $this->isCurrent = false;

        return $this;
    }

    public function getGreetings(): Greetings
    {
        return $this->greetings;
    }

    public function setGreetings(Greetings $greetings): self
    {
        $this->isInitialized = true;
        $this->greetings = $greetings;

        return $this;
    }

    public function getGender(): Gender
    {
        return Gender::createFromIntCode($this->gender);
    }

    public function setGender(Gender $gender): self
    {
        $this->gender = $gender->getIntCode();

        return $this;
    }

    public function isBirthdaySpecified(): bool
    {
        return $this->birthday !== null;
    }

    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTime $birthday): self
    {
        $now = new \DateTime();

        if($now < $birthday) {
            throw new InvalidBirthdayGuestFromTheFutureException(self::EXCEPTION_GUEST_FUTURE);
        }

        $diff = $birthday->diff(new \DateTime());
        $years = $diff->y;

        if($years < self::MIN_AGE) {
            throw new InvalidBirthdayException(self::EXCEPTION_YOUNG);
        }

        if($years > self::MAX_AGE) {
            throw new InvalidBirthdayException(self::EXCEPTION_OLD);
        }

        $this->birthday = $birthday;

        return $this;
    }

    public function unsetBirthday(): self
    {
        $this->birthday = null;

        return $this;
    }

    public function getInterestingInIds(): array
    {
        return $this->interestingInIds;
    }

    public function setInterestingInIds(array $themeIds): self
    {
        $this->interestingInIds = array_unique(array_filter($themeIds, 'is_int'));

        return $this;
    }

    public function getExpertInIds(): array
    {
        return $this->expertInIds;
    }

    public function setExpertInIds(array $themeIds): self
    {
        $this->expertInIds = array_unique(array_filter($themeIds, 'is_int'));

        return $this;
    }
}