<?php
namespace Profile\Entity;

/**
 * @Entity(repositoryClass="Profile\Repository\ProfileImageRepository")
 * @Table(name="profile_greetings")
 */
class ProfileImage
{
    /**
     * @var int
     * @Column(type="integer")
     */
    private $id;

    /**
     * @OneToOne(targetEntity="Profile\Entity\Profile")
     * @JoinColumn(name="profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $profile;

    /**
     * @var string
     * @Column(type="text")
     */
    private $publicPath;

    /**
     * @var string
     * @Column(type="string")
     */
    private $storagePath;

    public function __construct(Profile $profile, string $publicPath, string $storagePath)
    {
        $this->profile = $profile;
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