<?php
namespace Community\Entity;

use Common\Util\IdTrait;
use Community\Entity\Community\CommunityImage;
use Theme\Entity\Theme;

/**
 * @Entity(repositoryClass="Community\Repository\CommunityRepository")
 * @Table(name="community")
 */
class Community
{
    use IdTrait;

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
     * @ManyToOne(targetEntity="Theme\Entity\Theme")
     * @JoinColumn(name="theme_id", referencedColumnName="id")
     * @var \Theme\Entity\Theme
     */
    private $theme;

    /**
     * @Column(type="json_array", name="image")
     * @var array
     */
    private $image = [];

    public function __construct(string $title, string $description, Theme $theme)
    {
        $this->dateCreatedOn = new \DateTime();
        $this
            ->setTitle($title)
            ->setDescription($description)
            ->setTheme($theme);
    }

    public function toJSON(): array {
        $result = [
            'id' => $this->getId(),
            'date_created_on' => $this->dateCreatedOn->format(\DateTime::RFC2822),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'theme_id' => $this->getTheme()->getId(),
            'has_image' => $this->hasImage()
        ];

        if($result['has_image']) {
            $image = $this->getImage();

            $result['image'] = [
                'community_id' => $this->getId(),
                'public_path' => $image->getPublicPath()
            ];
        }

        return $result;
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

    public function getTheme(): Theme
    {
        return $this->theme;
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
}