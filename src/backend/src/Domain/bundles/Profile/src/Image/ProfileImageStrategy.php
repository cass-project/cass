<?php
namespace Domain\Profile\Image;

use Domain\Avatar\Entity\ImageEntity;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Strategy\SquareImageStrategy;
use Domain\Profile\Entity\Profile;
use League\Flysystem\FilesystemInterface;

final class ProfileImageStrategy extends SquareImageStrategy
{
    const DEFAULT_IMAGE_PUBLIC_PATH = '/dist/assets/profile/profile-default-avatar.png';
    const DEFAULT_IMAGE_STORAGE_DIR = __DIR__.'/../../../../../../../www/app/dist/assets/entity/profile/profile-default-avatar.png';

    /** @var Profile */
    private $profile;

    /** @var FilesystemInterface */
    private $fileSystem;

    public function __construct(Profile $profile, FilesystemInterface $fileSystem)
    {
        $this->profile = $profile;
        $this->fileSystem = $fileSystem;
    }

    public function getEntity(): ImageEntity
    {
        return $this->profile;
    }

    public function getEntityId(): string
    {
        return $this->profile->getSID();
    }

    public function getLetter(): string
    {
        return substr($this->profile->getGreetings()->__toString(), 0, 1);
    }

    public function getFilesystem(): FilesystemInterface
    {
        return $this->fileSystem;
    }

    public function getPublicPath(): string
    {
        return '/dist/assets/entity/profile/by-sid/avatar';
    }

    public function getDefaultImage(): Image
    {
        return new Image(self::DEFAULT_IMAGE_STORAGE_DIR, self::DEFAULT_IMAGE_PUBLIC_PATH);
    }
}