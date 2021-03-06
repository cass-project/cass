<?php
namespace CASS\Domain\Bundles\Collection\Image;

use CASS\Domain\Bundles\Avatar\Entity\ImageEntity;
use CASS\Domain\Bundles\Avatar\Image\Image;
use CASS\Domain\Bundles\Avatar\Strategy\SquareImageStrategy;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use League\Flysystem\FilesystemInterface;

final class CollectionImageStrategy extends SquareImageStrategy
{
    const DEFAULT_IMAGE_PUBLIC_PATH = '/dist/assets/collection/collection-default-avatar.png';
    const DEFAULT_IMAGE_STORAGE_DIR = __DIR__.'/../../../../../../../www/app/dist/assets/entity/collection/collection-default-avatar.png';

    /** @var Collection */
    private $collection;

    /** @var FilesystemInterface */
    private $fileSystem;
    
    /** @var string */
    private $wwwDir;

    public function __construct(Collection $collection, FilesystemInterface $fileSystem, string $wwwDir)
    {
        $this->collection = $collection;
        $this->fileSystem = $fileSystem;
        $this->wwwDir = $wwwDir;
    }

    public function getEntity(): ImageEntity
    {
        return $this->collection;
    }

    public function getEntityId(): string
    {
        return $this->collection->getSID();
    }

    public function getLetter(): string
    {
        return mb_substr($this->collection->getTitle(), 0, 1);
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