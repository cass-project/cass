<?php
namespace Domain\Profile\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\Entity\SIDEntity\SIDEntity;
use Application\Util\Entity\SIDEntity\SIDEntityTrait;
use Application\Util\JSONSerializable;
use Domain\Account\Entity\Account;
use Domain\Avatar\Entity\ImageEntity;
use Domain\Avatar\Entity\ImageEntityTrait;
use Domain\Avatar\Image\ImageCollection;
use Domain\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use Domain\Collection\Collection\CollectionTree\MutableCollectionTree;
use Domain\Collection\Strategy\CollectionAwareEntity;
use Domain\Collection\Strategy\Traits\CollectionAwareEntityTrait;
use Domain\Profile\Entity\Profile\Gender\Gender;
use Domain\Profile\Entity\Profile\Gender\GenderNotSpecified;
use Domain\Profile\Entity\Profile\Greetings\Greetings;
use Domain\Profile\Entity\Profile\Greetings\GreetingsAnonymous;

/**
 * @Entity(repositoryClass="Domain\Profile\Repository\ProfileRepository")
 * @Table(name="profile")
 */
final class Profile implements JSONSerializable, IdEntity, SIDEntity, ImageEntity, CollectionAwareEntity
{
    use IdTrait;
    use SIDEntityTrait;
    use CollectionAwareEntityTrait;
    use ImageEntityTrait;

    /**
     * @ManyToOne(targetEntity="Domain\Account\Entity\Account")
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

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
     * @Column(type="json_array", name="interesting_in_ids")
     * @var int[]
     */
    private $interestingInIds = [];

    /**
     * @Column(type="json_array", name="expert_in_ids")
     * @var int[]
     */
    private $expertInIds = [];

    public function toJSON(): array
    {
        $result = [
            'id' => $this->isPersisted() ? $this->getId() : '#NEW_PROFILE',
            'sid' => $this->getSID(),
            'account_id' => $this->getAccount()->isPersisted()
                ? $this->getAccount()->getId()
                : '#NEW_ACCOUNT'
            ,
            'is_current' => (bool)$this->isCurrent(),
            'is_initialized' => $this->isInitialized(),
            'greetings' => $this->getGreetings()->toJSON(),
            'gender' => $this->getGender()->toJSON(),
            'image' => $this->getImages()->toJSON(),
            'expert_in_ids' => $this->expertInIds,
            'interesting_in_ids' => $this->interestingInIds,
            'collections' => $this->getCollections()->toJSON(),
        ];

        return $result;
    }

    public function __construct(Account $account)
    {
        $this->account = $account;
        $this->collections = new ImmutableCollectionTree();
        $this->greetings = new GreetingsAnonymous();
        $this->gender = (new GenderNotSpecified())->getIntCode();

        $this->regenerateSID();
        $this->setImages(new ImageCollection());
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