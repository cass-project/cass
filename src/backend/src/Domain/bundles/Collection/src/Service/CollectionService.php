<?php
namespace Domain\Collection\Service;

use Domain\Avatar\Image\ImageCollection;
use Domain\Avatar\Parameters\UploadImageParameters;
use Domain\Avatar\Service\AvatarService;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Image\CollectionImageStrategy;
use Domain\Collection\Parameters\CreateCollectionParameters;
use Domain\Collection\Parameters\EditCollectionParameters;
use Domain\Collection\Parameters\SetPublicOptionsParameters;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;
use Evenement\EventEmitter;
use Evenement\EventEmitterInterface;
use League\Flysystem\FilesystemInterface;

class CollectionService
{
    const EVENT_ACCESS = 'domain.collection.access';
    const EVENT_CREATED = 'domain.collection.created';
    const EVENT_EDITED = 'domain.collection.edited';
    const EVENT_DELETE = 'domain.collection.delete';
    const EVENT_DELETED = 'domain.collection.deleted';
    const EVENT_OPTIONS = 'domain.collection.options';
    const EVENT_IMAGE_UPLOADED = 'domain.collection.image.uploaded';
    const EVENT_IMAGE_GENERATED = 'domain.collection.image.generated';

    /** @var EventEmitterInterface */
    private $events;

    /** @var CollectionRepository */
    private $collectionRepository;

    /** @var AvatarService */
    private $avatarService;

    /** @var FilesystemInterface */
    private $images;

    public function __construct(
        CollectionRepository $collectionRepository,
        AvatarService $avatarService,
        FilesystemInterface $imagesFlySystem)
    {
        $this->events = new EventEmitter();
        $this->collectionRepository = $collectionRepository;
        $this->avatarService = $avatarService;
        $this->images = $imagesFlySystem;
    }

    public function getEventEmitter(): EventEmitterInterface
    {
        return $this->events;
    }

    public function createCollection(CreateCollectionParameters $parameters, bool $disableAccess = false)
    {
        $collection = new Collection($parameters->getOwnerSID());

        if(! $disableAccess) {
            $this->events->emit(self::EVENT_ACCESS, [$collection]);
        }

        $collection
            ->setTitle($parameters->getTitle())
            ->setDescription($parameters->getDescription())
            ->setThemeIds($parameters->getThemeIds());

        $this->collectionRepository->createCollection($collection);
        $this->avatarService->generateImage(new CollectionImageStrategy($collection, $this->images));
        $this->collectionRepository->saveCollection($collection);

        $this->events->emit(self::EVENT_CREATED, [$collection]);

        return $collection;
    }

    public function editCollection(int $collectionId, EditCollectionParameters $parameters): Collection
    {
        $collection = $this->getCollectionById($collectionId);

        $this->events->emit(self::EVENT_ACCESS, [$collection]);

        $collection
            ->setTitle($parameters->getTitle())
            ->setDescription($parameters->getDescription())
            ->setThemeIds($parameters->getThemeIds());

        $this->collectionRepository->saveCollection($collection);

        $this->events->emit(self::EVENT_EDITED, [$collection]);

        return $collection;
    }

    public function deleteCollection(int $collectionId)
    {
        $collection = $this->getCollectionById($collectionId);

        $this->events->emit(self::EVENT_ACCESS, [$collection]);
        $this->events->emit(self::EVENT_DELETE, [$collection]);
        $this->collectionRepository->deleteCollection($collectionId);
        $this->events->emit(self::EVENT_DELETED, [$collection]);

        return $collection;
    }

    public function setPublicOptions(int $collectionId, SetPublicOptionsParameters $parameters): Collection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);

        $this->events->emit(self::EVENT_ACCESS, [$collection]);

        $collection->setPublicOptions([
            'is_private' => $parameters->isPrivate(),
            'public_enabled' => $parameters->isPublicEnabled(),
            'moderation_contract' => $parameters->isModerationContractEnabled()
        ]);

        $this->collectionRepository->saveCollection($collection);
        $this->events->emit(self::EVENT_OPTIONS, [$collection]);

        return $collection;
    }

    public function uploadImage(int $collectionId, UploadImageParameters $parameters): ImageCollection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);

        $this->events->emit(self::EVENT_ACCESS, [$collection]);
        $this->avatarService->uploadImage(new CollectionImageStrategy($collection, $this->images), $parameters);
        $this->collectionRepository->saveCollection($collection);
        $this->events->emit(self::EVENT_IMAGE_UPLOADED, [$collection]);

        return $collection->getImages();
    }

    public function generateImage(int $collectionId): ImageCollection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);

        $this->events->emit(self::EVENT_ACCESS, [$collection]);
        $this->avatarService->generateImage(new CollectionImageStrategy($collection, $this->images));
        $this->collectionRepository->saveCollection($collection);
        $this->events->emit(self::EVENT_IMAGE_GENERATED, [$collection]);

        return $collection->getImages();
    }

    public function getCollectionById(int $collectionId): Collection
    {
        return $this->collectionRepository->getCollectionById($collectionId);
    }

    public function getCollectionsById(array $collectionIds): array
    {
        return $this->collectionRepository->getCollectionsById($collectionIds);
    }
}