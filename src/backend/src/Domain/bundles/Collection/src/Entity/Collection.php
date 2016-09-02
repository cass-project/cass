<?php
namespace CASS\Domain\Bundles\Collection\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\Entity\SIDEntity\SIDEntity;
use CASS\Util\Entity\SIDEntity\SIDEntityTrait;
use CASS\Util\JSONSerializable;
use CASS\Domain\Bundles\Avatar\Entity\ImageEntity;
use CASS\Domain\Bundles\Collection\Exception\InvalidCollectionOptionsException;
use CASS\Domain\Bundles\Collection\Exception\PublicEnabledException;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Avatar\Entity\ImageEntityTrait;
use CASS\Domain\Bundles\Index\Entity\IndexedEntity;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;
use CASS\Domain\Bundles\Theme\Strategy\ThemeIdsEntityAware;
use CASS\Domain\Bundles\Theme\Strategy\Traits\ThemeIdsAwareEntityTrait;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Collection\Repository\CollectionRepository")
 * @Table(name="collection")
 */
class Collection implements JSONSerializable, IdEntity, SIDEntity, ImageEntity, ThemeIdsEntityAware, IndexedEntity
{
    use IdTrait;
    use SIDEntityTrait;
    use ImageEntityTrait;
    use ThemeIdsAwareEntityTrait;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @Column(type="string", name="owner_sid")
     * @var string
     */
    private $ownerSID;

    /**
     * @Column(type="string")
     * @var string
     */
    private $title = '';

    /**
     * @Column(type="string")
     * @var string
     */
    private $description = '';

    /**
     * @Column(type="boolean", name="is_private")
     * @var bool
     */
    private $isPrivate = false;

    /**
     * @Column(type="boolean", name="public_enabled")
     * @var boolean
     */
    private $publicEnabled = true;

    /**
     * @Column(type="boolean", name="moderation_contract")
     * @var boolean
     */
    private $moderationContract = false;

    /**
     * @Column(type="boolean", name="is_protected")
     * @var bool
     */
    private $isProtected = false;

    /**
     * @Column(type="boolean", name="is_main")
     * @var bool
     */
    private $isMain = false;

    public function __construct(string $ownerSID)
    {
        $this->ownerSID = $ownerSID;
        $this->dateCreatedOn = new \DateTime();
        $this->regenerateSID();
    }

    public function toJSON(): array
    {
        $result = [
            'id' => $this->getId(),
            'sid' => $this->getSID(),
            'owner_sid' => $this->getOwnerSID(),
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'owner' => [
                'id' => $this->getOwnerId(),
                'type' => $this->getOwnerType(),
            ],
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'theme_ids' => $this->getThemeIds(),
            'public_options' => [
                'is_private' => $this->isPrivate(),
                'public_enabled' => $this->isPublicEnabled(),
                'moderation_contract' => $this->isModerationContractEnabled(),
            ],
            'image' => $this->getImages()->toJSON(),
            'is_protected' => $this->isProtected(),
            'is_main' => $this->isMain(),
        ];
        return $result;
    }

    public function toIndexedEntityJSON(): array
    {
        return array_merge($this->toJSON(), [
            'date_created_on' => $this->getDateCreatedOn()
        ]);
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function getOwnerSID(): string
    {
        return $this->ownerSID;
    }

    public function getOwnerType(): string
    {
        list($type, ) = explode(':', $this->getOwnerSID());

        return $type;
    }

    public function getOwnerId(): string
    {
        list(, $id) = explode(':', $this->getOwnerSID());

        return $id;
    }

    public function isProfileCollection(): bool
    {
        return $this->getOwnerType() === 'profile';
    }

    public function isCommunityCollection(): bool
    {
        return $this->getOwnerType() === 'collection';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setOwnerProfile(int $profileId): self
    {
        $this->ownerSID = sprintf('profile:%d', $profileId);
        return $this;
    }

    public function setOwnerCommunity(int $communityId): self
    {
        $this->ownerSID = sprintf('community:%d', $communityId);
        return $this;
    }

    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    public function setAsPrivate(): self
    {
        if($this->isPublicEnabled()) {
            throw new PublicEnabledException(sprintf('Collection `%s` is public', $this->getId()));
        }

        $this->isPrivate = true;

        return $this;
    }

    public function unsetAsPrivate(): self
    {
        $this->isPrivate = false;

        return $this;
    }

    public function isPublicEnabled(): bool
    {
        return $this->publicEnabled;
    }

    public function isModerationContractEnabled(): bool
    {
        return $this->moderationContract;
    }

    public function setPublicOptions(array $options): self
    {
        foreach(['is_private', 'public_enabled', 'moderation_contract'] as $required) {
            if(!(isset($options[$required]) && is_bool($options[$required]))) {
                throw new \InvalidArgumentException('Invalid public options');
            }
        }

        $isPrivate = $options['is_private'];
        $publicEnabled = $options['public_enabled'];
        $moderationContract = $options['moderation_contract'];

        if($isPrivate && $publicEnabled) {
            throw new InvalidCollectionOptionsException(sprintf(
                'Collection %s cannot be both private and indexed by public catalog',
                $this->isPersisted() ? $this->getId() : '#NEW_COLLECTION'
            ));
        }

        $this->isPrivate = $isPrivate;
        $this->publicEnabled = $publicEnabled;
        $this->moderationContract = $moderationContract;

        return $this;
    }

    public function isProtected(): bool
    {
        return $this->isProtected;
    }

    public function enableProtection(): self
    {
        $this->isProtected = true;

        return $this;
    }

    public function defineAsMain(): self
    {
        $this->isMain = true;
        $this->enableProtection();

        return $this;
    }

    public function isMain(): bool
    {
        return $this->isMain;
    }
}