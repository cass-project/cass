<?php
namespace CASS\Domain\Bundles\Profile\Image;

use CASS\Domain\Bundles\Avatar\Entity\ImageEntity;
use CASS\Domain\Bundles\Avatar\Image\Image;
use CASS\Domain\Bundles\Avatar\Strategy\SquareImageStrategy;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use League\Flysystem\FilesystemInterface;

final class ProfileImageStrategy extends SquareImageStrategy
{
    const DEFAULT_IMAGE_PUBLIC_PATH = '/dist/assets/profile/profile-default-avatar.png';
    const DEFAULT_IMAGE_STORAGE_DIR = __DIR__.'/../../../../../../../www/app/dist/assets/entity/profile/profile-default-avatar.png';

    /** @var Profile */
    private $profile;

    /** @var FilesystemInterface */
    private $fileSystem;
    
    /** @var string */
    private $wwwDir;

    public function __construct(Profile $profile, FilesystemInterface $fileSystem, string $wwwDir)
    {
        $this->profile = $profile;
        $this->fileSystem = $fileSystem;
        $this->wwwDir = $wwwDir;
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
        return $this->wwwDir;
    }

    public function getDefaultImage(): Image
    {
        return new Image(self::DEFAULT_IMAGE_STORAGE_DIR, self::DEFAULT_IMAGE_PUBLIC_PATH);
    }
}