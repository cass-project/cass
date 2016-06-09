<?php
namespace Domain\Community\Entity;

use Application\Util\GenerateRandomString;
use Application\Util\IdTrait;
use Domain\Collection\Collection\CollectionTree;
use Domain\Collection\Traits\CollectionOwnerTrait;
use Domain\Community\Entity\Community\CommunityFeatures;
use Domain\Community\Entity\Community\CommunityImage;
use Domain\Theme\Entity\Theme;

/**
 * @Entity(repositoryClass="Domain\Community\Repository\CommunityRepository")
 * @Table(name="community")
 */
class Community
{
    const SID_LENGTH = 8;

    use IdTrait;
    use CollectionOwnerTrait;

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
     * @Column(type="json_array", name="image")
     * @var array
     */
    private $image = [];

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
    private $publicEnabled = true;

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
        $this->collections = new CollectionTree();
        $this->setTitle($title)->setDescription($description);

        if($theme) {
            $this->setTheme($theme);
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
            'description' => $this->getDescription(),
            'has_image' => $this->hasImage(),
            'collections' => $this->collections->toJSON(),
            'public_options' => [

            ]
        ];

        if($this->hasTheme()) {
            $result['theme']['id'] = $this->getTheme()->getId();
        }

        if($result['has_image']) {
            $image = $this->getImage();

            $result['image'] = [
                'community_id' => $this->getId(),
                'public_path' => $image->getPublicPath()
            ];
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
        $this->disableModerationContract();

        $this->theme = null;

        return $this;
    }

    public function setTheme(Theme $theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    public function clearImage() {
        $this->image = [];
    }

    public function setImage(CommunityImage $communityImage) {
        $this->image = [
            'storage_path' => $communityImage->getStoragePath(),
            'public_path' => $communityImage->getPublicPath()
        ];
    }

    public function getImage(): CommunityImage {
        if($this->hasImage()) {
            return new CommunityImage($this->image['storage_path'], $this->image['public_path']);
        }else{
            throw new \Exception(sprintf('No image available for community `%s`', ($this->isPersisted() ? $this->getId() : '#NEW_COMMUNITY')));
        }
    }

    public function hasImage() {
        return isset($this->image['storage_path'])
            && is_string($this->image['storage_path'])
            && file_exists($this->image['storage_path']);
    }

    public function getFeatures(): CommunityFeatures {
        if($this->featuresHandler === null) {
            $this->featuresHandler = new CommunityFeatures($this->features);
        }

        return $this->featuresHandler;
    }

    public function isPublicEnabled(): boolean
    {
        return $this->publicEnabled;
    }

    public function enablePublicDiscover(): self
    {
        if(! $this->hasTheme()) {
            throw new \Exception('No theme available');
        }

        $this->publicEnabled = true;

        return $this;
    }

    public function disablePublicDiscover(): self
    {
        $this->publicEnabled = false;

        return $this;
    }

    public function isModerationContractEnabled(): boolean
    {
        return $this->publicModerationContract;
    }

    public function enableModerationContract(): self
    {
        if(! $this->hasTheme()) {
            throw new \Exception('No theme available');
        }

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