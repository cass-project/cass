<?php
namespace Domain\Post\Entity;

use Application\Util\Entity\IdEntity\IdEntity;
use Application\Util\Entity\IdEntity\IdTrait;
use Application\Util\JSONSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as DoctrineCollection;
use Domain\Collection\Entity\Collection;
use Domain\Feed\Service\Entity;
use Domain\Post\PostType\PostType;
use Domain\Profile\Entity\Profile;
use Domain\Theme\Strategy\ThemeIdsEntityAware;
use Domain\Theme\Strategy\Traits\ThemeIdsAwareEntityTrait;

/**
 * @Entity(repositoryClass="Domain\Post\Repository\PostRepository")
 * @Table(name="post")
 */
class Post implements IdEntity, JSONSerializable, ThemeIdsEntityAware, Entity
{
    use IdTrait;
    use ThemeIdsAwareEntityTrait;

    /**
     * @Column(type="integer", name="post_type")
     * @var int
     */
    private $postTypeCode;

    /**
     * @ManyToOne(targetEntity="Domain\Profile\Entity\Profile")
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
     * @ManyToOne(targetEntity="Domain\Collection\Entity\Collection")
     * @JoinColumn(name="collection_id", referencedColumnName="id")
     * @var Collection
     */
    private $collection;

    /**
     * @Column(type="text")
     * @var string
     */
    private $content;

    /**
     * @OneToMany(targetEntity="Domain\PostAttachment\Entity\PostAttachment", mappedBy="post", cascade={"all"})
     * @var DoctrineCollection
     */
    private $attachments;

    public function __construct(
        PostType $postType,
        Profile $authorProfile,
        Collection $collection,
        string $content
    ) {
        $this->postTypeCode = $postType->getIntCode();
        $this->authorProfile = $authorProfile;
        $this->collection = $collection;
        $this->content = $content;
        $this->dateCreatedOn = new \DateTime();
        $this->attachments = new ArrayCollection();
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'post_type' => $this->postTypeCode,
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'profile_id' => $this->getAuthorProfile()->getId(),
            'collection_id' => $this->getCollection()->getId(),
            'content' => $this->getContent(),
            'theme_ids' => $this->getThemeIds(),
        ];
    }

    public function toIndexedJSON(): array
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAttachments(): DoctrineCollection
    {
        return $this->attachments;
    }
}