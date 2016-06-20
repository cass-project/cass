<?php
namespace Domain\Community\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\GenerateRandomString;
use Application\Util\JSONSerializable;
use Domain\Avatar\Entity\ImageEntity;
use Domain\Avatar\Entity\ImageEntityTrait;
use Domain\Avatar\Image\ImageCollection;
use Domain\Collection\Collection\CollectionTree\ImmutableCollectionTree;
use Domain\Collection\Strategy\CollectionAwareEntity;
use Domain\Collection\Strategy\Traits\CollectionAwareEntityTrait;
use Domain\Community\Entity\Community\CommunityFeatures;
use Domain\Community\Exception\CommunityHasNoThemeException;
use Domain\Theme\Entity\Theme;

/**
 * @Entity(repositoryClass="Domain\Community\Repository\CommunityRepository")
 * @Table(name="community")
 */
class Community implements IdEntity, JSONSerializable, ImageEntity, CollectionAwareEntity
{
    const SID_LENGTH = 8;

    use IdTrait;
    use CollectionAwareEntityTrait;
    use ImageEntityTrait;

    /**
     * @Column(type="string", name="sid")
     * @var string
     */
    private $sid;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @Column(type="string")
     * @var string
     */
    private $title;

    /**
     * @Column(type="string")
     * @var string
     */
    private $description;

    /**
     * @ManyToOne(targetEntity="Domain\Theme\Entity\Theme")
     * @JoinColumn(name="theme_id", referencedColumnName="id")
     * @var Theme|null
     */
    private $theme;

    /**
     * @Column(type="json_array", name="features")
     * @var array
     */
    private $features = [];

    /**
     * @Column(type="json_array", name="metadata")
     * @var array
     */
    private $metadata = [];

    /** @var CommunityFeatures */
    private $featuresHandler;

    /**
     * @Column(type="boolean", name="public_enabled")
     * @var bool
     */
    private $publicEnabled = false;

    /**
     * @Column(type="boolean", name="public_moderation_contract")
     * @var bool
     */
    private $publicModerationContract = false;

    public function __construct(int $creatorAccountId, string $title, string $description, Theme $theme = null)
    {
        $this->metadata = [
            'creatorAccountId' => $creatorAccountId
        ];
        $this->sid = GenerateRandomString::gen(self::SID_LENGTH);
        $this->dateCreatedOn = new \DateTime();
        $this->collections = new ImmutableCollectionTree();
        $this->setTitle($title)->setDescription($description);
        $this->setImages(new ImageCollection());

        if($theme) {
            $this->setTheme($theme);
            $this->enablePublicDiscover();
        }
    }

    public function toJSON(): array {
        $result = [
            'id' => $this->getId(),
            'sid' => $this->getSID(),
            'date_created_on' => $this->dateCreatedOn->format(\DateTime::RFC2822),
            'title' => $this->getTitle(),
            'theme' => [
                'has' => $this->hasTheme(),
            ],
            'image' => $this->image,
            'description' => $this->getDescription(),
            'collections' => $this->collections->toJSON(),
            'public_options' => [
                'public_enabled' => $this->isPublicEnabled(),
                'moderation_contract' => $this->isModerationContractEnabled(),
            ]
        ];

        if($this->hasTheme()) {
            $result['theme']['id'] = $this->getTheme()->getId();
        }

        return $result;
    }

    public function getSID(): string
    {
        return $this->sid;
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
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

    public function hasTheme(): bool
    {
        return $this->theme !== null;
    }

    public function getTheme(): Theme
    {
        return $this->theme;
    }

    public function unsetTheme(): self
    {
        $this->disablePublicDiscover();

        $this->theme = null;

        return $this;
    }

    public function setTheme(Theme $theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    public function getFeatures(): CommunityFeatures {
        if($this->featuresHandler === null) {
            $this->featuresHandler = new CommunityFeatures($this->features);
        }

        return $this->featuresHandler;
    }

    public function isPublicEnabled(): bool
    {
        return $this->publicEnabled;
    }

    public function enablePublicDiscover(): self
    {
        if(! $this->hasTheme()) {
            throw new CommunityHasNoThemeException('No theme available');
        }

        $this->publicEnabled = true;

        return $this;
    }

    public function disablePublicDiscover(): self
    {
        $this->publicEnabled = false;

        return $this;
    }

    public function isModerationContractEnabled(): bool
    {
        return $this->publicModerationContract;
    }

    public function enableModerationContract(): self
    {
        $this->publicModerationContract = true;

        return $this;
    }

    public function disableModerationContract(): self
    {
        $this->publicModerationContract = false;

        return $this;
    }

    public function &getMetadata(): array {
        return $this->metadata;
    }
}