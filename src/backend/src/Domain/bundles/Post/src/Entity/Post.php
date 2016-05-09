<?php
namespace Domain\Post\Entity;

use Domain\Collection\Entity\Collection;
use Domain\Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="Domain\Post\Repository\PostRepository")
 * @Table(name="post")
 */
class Post
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

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
     * @ManyToOne(targetEntity="Domain\Collection\Entity\Domain\Collection")
     * @JoinColumn(name="collection_id", referencedColumnName="id")
     * @var Collection
     */
    private $collection;

    /**
     * @Column(type="text")
     * @var string
     */
    private $content;

    public function __construct(Profile $authorProfile, Collection $collection, string $content) {
        $this->authorProfile = $authorProfile;
        $this->collection = $collection;
        $this->content = $content;
        $this->dateCreatedOn = new \DateTime();
    }

    public function toJSON() {
        return [
            'id' => $this->getId(),
            'date_create_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'author_profile_id' => $this->getAuthorProfile()->getId(),
            'collection_id' => $this->getCollection()->getId(),
            'content' => $this->getContent()
        ];
    }

    public function isPersisted() {
        return $this->id !== null;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getAuthorProfile(): Profile {
        return $this->authorProfile;
    }

    public function getCollection(): Collection {
        return $this->collection;
    }

    public function setCollection(Collection $collection): self {
        $this->collection = $collection;

        return $this;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getDateCreatedOn(): \DateTime {
        return $this->dateCreatedOn;
    }

    public function setContent(string $content): self {
        $this->content = $content;

        return $this;
    }
}