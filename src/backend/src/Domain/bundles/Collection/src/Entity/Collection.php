<?php
namespace Domain\Collection\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\Entity\SIDEntity\SIDEntity;
use Application\Util\Entity\SIDEntity\SIDEntityTrait;
use Application\Util\JSONSerializable;
use Domain\Avatar\Entity\ImageEntity;
use Domain\Collection\Exception\InvalidCollectionOptionsException;
use Domain\Collection\Exception\PublicEnabledException;
use Domain\Community\Entity\Community;
use Domain\Avatar\Entity\ImageEntityTrait;
use Domain\Index\Entity\IndexedEntity;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\Theme\Strategy\ThemeIdsEntityAware;
use Domain\Theme\Strategy\Traits\ThemeIdsAwareEntityTrait;

/**
 * @Entity(repositoryClass="Domain\Collection\Repository\CollectionRepository")
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
            'image' => $this->getImages()->toJSON()
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
}