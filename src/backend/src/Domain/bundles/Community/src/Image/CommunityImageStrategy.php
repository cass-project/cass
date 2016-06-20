<?php
namespace Domain\Community\Image;

use Domain\Avatar\Entity\ImageEntity;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Strategy\SquareImageStrategy;
use Domain\Community\Entity\Community;
use League\Flysystem\FilesystemInterface;

final class CommunityImageStrategy extends SquareImageStrategy
{
    const DEFAULT_IMAGE_PUBLIC_PATH = '/dist/assets/community/community-default.png';
    const DEFAULT_IMAGE_STORAGE_DIR = __DIR__.'/../../../../../../../www/app/dist/assets/community/community-default.png';

    /** @var Community */
    private $community;

    /** @var FilesystemInterface */
    private $fileSystem;

    public function __construct(Community $community, FilesystemInterface $fileSystem)
    {
        if(! $community->isPersisted()) {
            throw new \Exception('Entity is not persisted yet');
        }

        $this->community = $community;
        $this->fileSystem = $fileSystem;
    }

    public function getEntity(): ImageEntity
    {
        return $this->community;
    }

    public function getEntityId(): string {
        return (string) $this->community->getSID();
    }

    public function getLetter(): string
    {
        if(! strlen($this->community->getTitle())) {
            throw new \Exception('No title available');
        }

        return substr($this->community->getTitle(), 0, 1);
    }

    public function getFilesystem(): FilesystemInterface
    {
        return $this->fileSystem;
    }

    public function getPublicPath(): string
    {
        return '/dist/assets/community/by-sid/avatar';
    }

    public function getDefaultImage(): Image
    {
        return new Image(self::DEFAULT_IMAGE_STORAGE_DIR, self::DEFAULT_IMAGE_PUBLIC_PATH);
    }
}