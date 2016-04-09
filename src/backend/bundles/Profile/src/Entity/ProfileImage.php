<?php
namespace Profile\Entity;

/**
 * @Entity(repositoryClass="Profile\Repository\ProfileImageRepository")
 * @Table(name="profile_image")
 */
class ProfileImage
{
    const DEFAULT_PROFILE_IMAGE_PUBLIC = '/public/assets/profile-default.png';
    const DEFAULT_PROFILE_IMAGE_STORAGE = __DIR__.'/../../../../../www/app/public/assets/profile-default.png';

    /**
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @OneToOne(targetEntity="Profile\Entity\Profile", inversedBy="profileImage")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @var string
     * @Column(type="text", name="public_path")
     */
    private $publicPath;

    /**
     * @var string
     * @Column(type="string", name="storage_path")
     */
    private $storagePath;

    public function __construct(
        Profile $profile,
        string $publicPath = self::DEFAULT_PROFILE_IMAGE_PUBLIC,
        string $storagePath = self::DEFAULT_PROFILE_IMAGE_STORAGE)
    {
        $this->profile = $profile;
        $this->profile->setProfileImage($this);
        $this->publicPath = $publicPath;
        $this->storagePath = $storagePath;
    }

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProfile(): Profile
    {
        return $this->profile;
    }

    public function getPublicPath(): string
    {
        return $this->publicPath;
    }

    public function setPublicPath(string $publicPath): self
    {
        $this->publicPath = $publicPath;

        return $this;
    }

    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    public function setStoragePath(string $storagePath): self
    {
        $this->storagePath = $storagePath;

        return $this;
    }
}