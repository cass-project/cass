<?php
namespace Domain\Collection\Entity;

use Application\Util\IdTrait;
use Application\Util\JSONSerializable;
use Domain\Collection\Exception\InvalidCollectionOptionsException;
use Domain\Collection\Exception\PublicEnabledException;
use Domain\Community\Entity\Community;
use Domain\Avatar\Entity\ImageEntityTrait;
use Domain\Profile\Entity\Profile;
use Domain\Theme\Entity\Theme;

/**
 * @Entity(repositoryClass="Domain\Collection\Repository\CollectionRepository")
 * @Table(name="collection")
 */
class Collection implements JSONSerializable
{
    use IdTrait;
    use ImageEntityTrait;

    /**
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
     * @JoinColumn(name="author_profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $authorProfile;

    /**
     * @Column(type="string", name="owner_sid")
     * @var string
     */
    private $ownerSID;

    /**
     * @ManyToOne(targetEntity="Domain\Theme\Entity\Theme")
     * @JoinColumn(name="theme_id", referencedColumnName="id")
     * @var Theme
     */
    private $theme;

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

    public function __construct(
        Profile $authorProfile,
        string $ownerSID,
        string $title,
        string $description,
        Theme $theme = null
    ) {
        $this->authorProfile = $authorProfile;
        $this->ownerSID = $ownerSID;
        $this->theme = $theme;
        $this->title = $title;
        $this->description = $description;
    }

    public function toJSON(): array
    {
        $result = [
            'id' => $this->getId(),
            'author_profile_id' => $this->getAuthorProfile()->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'theme' => [
                'has' => $this->hasTheme()
            ],
            'public_options' => [
                'is_private' => $this->isPrivate(),
                'public_enabled' => $this->isPublicEnabled(),
                'moderation_contract' => $this->isModerationContractEnabled(),
            ],
            'image' => $this->fetchImages()->toJSON()
        ];

        if($this->hasTheme()) {
            $result['theme']['id'] = $this->hasTheme() ? $this->getTheme()->getId() : null;
        }

        return $result;
    }

    public function getAuthorProfile(): Profile
    {
        return $this->authorProfile;
    }

    public function getOwnerSID(): string
    {
        return $this->ownerSID;
    }

    public function getTheme(): Theme
    {
        return $this->theme;
    }

    public function unsetTheme()
    {
        $this->theme = null;
    }

    public function hasTheme(): bool
    {
        return $this->theme !== null;
    }

    public function setTheme($theme): self
    {
        $this->theme = $theme;
        return $this;
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
            if(! (isset($options[$required]) && is_bool($options[$required]))) {
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