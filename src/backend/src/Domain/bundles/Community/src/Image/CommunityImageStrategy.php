<?php
namespace Domain\Community\Image;

use Domain\Avatar\Entity\ImageEntityTrait;
use Domain\Avatar\Image\Image;
use Domain\Avatar\Service\Context\AvatarStrategy;
use Domain\Community\Entity\Community;
use League\Flysystem\Filesystem;

final class CommunityImageStrategy implements AvatarStrategy
{
    const DEFAULT_IMAGE_PUBLIC_PATH = '/dist/assets/community/community-default.png';
    const DEFAULT_IMAGE_STORAGE_DIR = __DIR__.'/../../../../../../../www/app/dist/assets/community/community-default.png';

    /** @var Community */
    private $community;

    /** @var Filesystem */
    private $fileSystem;

    public function __construct(Community $community, Filesystem $fileSystem)
    {
        $this->community = $community;
        $this->fileSystem = $fileSystem;
    }

    public function getEntity(): ImageEntityTrait
    {
        return $this->community;
    }

    public function getEntityId(): string {
        return (string) $this->community->getId();
    }

    public function getLetter(): string
    {
        if(! strlen($this->community->getTitle())) {
            throw new \Exception('No title available');
        }

        return substr($this->community->getTitle(), 0, 1);
    }

    public function getFilesystem(): Filesystem
    {
        return $this->fileSystem;
    }

    public function getPublicPath(): string
    {
        return '/dist/assets/community';
    }

    public function getDefaultImage(): Image
    {
        return new Image(self::DEFAULT_IMAGE_STORAGE_DIR, self::DEFAULT_IMAGE_PUBLIC_PATH);
    }

    public function getDefaultSize(): int {
        return 64;
    }

    public function getSizes(): array {
        return [
            512,
            256,
            128,
            64,
            32,
            16
        ];
    }

    public function getRatio(): string {
        return "1:1";
    }
}