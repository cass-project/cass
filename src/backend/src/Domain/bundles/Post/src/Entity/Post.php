<?php
namespace CASS\Domain\Bundles\Post\Entity;

use ZEA2\Platform\Markers\IdEntity\IdEntity;
use ZEA2\Platform\Markers\IdEntity\IdEntityTrait;
use CASS\Util\JSONSerializable;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Index\Entity\IndexedEntity;
use CASS\Domain\Bundles\Post\PostType\PostType;

use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Theme\Strategy\ThemeIdsEntityAware;
use CASS\Domain\Bundles\Theme\Strategy\Traits\ThemeIdsAwareEntityTrait;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntityTrait;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Post\Repository\PostRepository")
 * @Table(name="post")
 */
class Post implements IdEntity, JSONSerializable, ThemeIdsEntityAware, IndexedEntity, LikeableEntity
{
    use IdEntityTrait;
    use ThemeIdsAwareEntityTrait;
    use LikeableEntityTrait;

    /**
     * @Column(type="integer", name="post_type")
     * @var int
     */
    private $postTypeCode;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Profile\Entity\Profile")
     * @JoinColumn(name="author_profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $authorProfile;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Collection\Entity\Collection")
     * @JoinColumn(name="collection_id", referencedColumnName="id")
     * @var Collection
     */
    private $collection;

    /**
     * @Column(type="text")
     * @var string
     */
    private $title;

    /**
     * @Column(type="text")
     * @var string
     */
    private $content;

    /**
     * @Column(name="attachment_ids", type="json_array")
     * @var int[]
     */
    private $attachmentIds = [];

    public function __construct(
        PostType $postType,
        Profile $authorProfile,
        Collection $collection,
        /* TODO: PHP7.1 ?string*/ $title,
        string $content
    ) {
        $this->postTypeCode = $postType->getIntCode();
        $this->authorProfile = $authorProfile;
        $this->collection = $collection;
        $this->title = $title;
        $this->content = $content;
        $this->dateCreatedOn = new \DateTime();
    }

    public function toJSON(): array
    {
        $result = [
            'id' => $this->getId(),
            'post_type' => $this->postTypeCode,
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'profile_id' => $this->getAuthorProfile()->getId(),
            'collection_id' => $this->getCollection()->getId(),
            'title' => [
                'has' => $this->hasTitle()
            ],
            'content' => $this->getContent(),
            'theme_ids' => $this->getThemeIds(),
            'attachment_ids' => $this->getAttachmentIds(),
            'likes' => $this->likes,
            'dislikes' => $this->dislikes
        ];

        if($this->hasTitle()) {
            $result['title']['value'] = $this->getTitle();
        }

        return $result;
    }

    public function toIndexedEntityJSON(): array
    {
        return array_merge($this->toJSON(), [
            'date_created_on' => $this->getDateCreatedOn()
        ]);
    }

    public function getPostTypeCode(): int
    {
        return $this->postTypeCode;
    }

    public function getAuthorProfile(): Profile
    {
        return $this->authorProfile;
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function setCollection(Collection $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function hasTitle(): bool
    {
        return $this->title !== null;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function replaceDateCreatedOn(\DateTime $newDate): self
    {
        $this->dateCreatedOn = $newDate;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function hasAttachments(): bool
    {
        return count($this->attachmentIds) > 0;
    }

    public function getAttachmentIds(): array
    {
        return $this->attachmentIds;
    }

    public function setAttachmentIds(array $attachmentIds): self
    {
        $this->attachmentIds = array_filter($attachmentIds, function($input) {
            return is_int($input);
        });

        return $this;
    }
}