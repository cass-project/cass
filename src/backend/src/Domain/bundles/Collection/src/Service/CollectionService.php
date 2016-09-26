<?php
namespace CASS\Domain\Bundles\Collection\Service;

use CASS\Application\Service\EventEmitterAware\EventEmitterAwareService;
use CASS\Application\Service\EventEmitterAware\EventEmitterAwareTrait;
use CASS\Domain\Bundles\Avatar\Image\ImageCollection;
use CASS\Domain\Bundles\Avatar\Parameters\UploadImageParameters;
use CASS\Domain\Bundles\Avatar\Service\AvatarService;
use CASS\Domain\Bundles\Backdrop\Factory\PresetFactory;
use CASS\Domain\Bundles\Backdrop\Service\BackdropService;
use CASS\Domain\Bundles\Collection\Backdrop\Preset\CollectionBackdropPresetFactory;
use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Collection\Exception\CollectionIsProtectedException;
use CASS\Domain\Bundles\Collection\Image\CollectionImageStrategy;
use CASS\Domain\Bundles\Collection\Parameters\CreateCollectionParameters;
use CASS\Domain\Bundles\Collection\Parameters\EditCollectionParameters;
use CASS\Domain\Bundles\Collection\Parameters\SetPublicOptionsParameters;
use CASS\Domain\Bundles\Collection\Repository\CollectionRepository;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;
use League\Flysystem\FilesystemInterface;

class CollectionService implements EventEmitterAwareService
{
    use EventEmitterAwareTrait;

    const EVENT_COLLECTION_ACCESS = 'domain.collection.access';
    const EVENT_COLLECTION_CREATED = 'domain.collection.created';
    const EVENT_COLLECTION_EDITED = 'domain.collection.edited';
    const EVENT_COLLECTION_DELETE = 'domain.collection.delete';
    const EVENT_COLLECTION_DELETED = 'domain.collection.deleted';
    const EVENT_COLLECTION_OPTIONS = 'domain.collection.options';
    const EVENT_COLLECTION_IMAGE_UPLOADED = 'domain.collection.image.uploaded';
    const EVENT_COLLECTION_IMAGE_GENERATED = 'domain.collection.image.generated';

    /** @var CollectionRepository */
    private $collectionRepository;

    /** @var AvatarService */
    private $avatarService;

    /** @var BackdropService */
    private $backdropService;

    /** @var PresetFactory */
    private $presetFactory;

    /** @var FilesystemInterface */
    private $images;

    /** @var string */
    private $wwwImagesDir;

    public function __construct(
        CollectionRepository $collectionRepository,
        AvatarService $avatarService,
        FilesystemInterface $imagesFlySystem,
        BackdropService $backdropService,
        CollectionBackdropPresetFactory $presetFactory,
        string $wwwImagesDir
    ) {
        $this->collectionRepository = $collectionRepository;
        $this->avatarService = $avatarService;
        $this->backdropService = $backdropService;
        $this->presetFactory = $presetFactory;
        $this->images = $imagesFlySystem;
        $this->wwwImagesDir = $wwwImagesDir;
    }

    public function createCollection(CreateCollectionParameters $parameters, bool $disableAccess = false)
    {
        $collection = new Collection($parameters->getOwnerSID());

        if(! $disableAccess) {
            $this->getEventEmitter()->emit(self::EVENT_COLLECTION_ACCESS, [$collection]);
        }

        $collection
            ->setTitle($parameters->getTitle())
            ->setDescription($parameters->getDescription())
            ->setThemeIds($parameters->getThemeIds());

        $this->collectionRepository->createCollection($collection);
        $this->avatarService->generateImage(new CollectionImageStrategy($collection, $this->images, $this->wwwImagesDir));
        $this->backdropService->backdropPreset($collection, $this->presetFactory, $this->presetFactory->getListIds()[array_rand($this->presetFactory->getListIds())]);
        $this->collectionRepository->saveCollection($collection);

        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_CREATED, [$collection]);

        return $collection;
    }

    public function editCollection(int $collectionId, EditCollectionParameters $parameters): Collection
    {
        $collection = $this->getCollectionById($collectionId);

        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_ACCESS, [$collection]);

        $collection
            ->setTitle($parameters->getTitle())
            ->setDescription($parameters->getDescription())
            ->setThemeIds($parameters->getThemeIds());

        $this->collectionRepository->saveCollection($collection);

        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_EDITED, [$collection]);

        return $collection;
    }

    public function editThemeIds(int $collectionId, array $themeIds): Collection
    {
        $collection = $this->getCollectionById($collectionId);
        $collection->setThemeIds($themeIds);

        $this->collectionRepository->saveCollection($collection);
        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_EDITED, [$collection]);

        return $collection;
    }

    public function deleteCollection(int $collectionId)
    {
        $collection = $this->getCollectionById($collectionId);

        if($collection->isProtected()) {
            throw new CollectionIsProtectedException(sprintf('Collection(id: `%s`) is protected', $collectionId));
        }

        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_ACCESS, [$collection]);
        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_DELETE, [$collection]);
        $this->collectionRepository->deleteCollection($collectionId);
        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_DELETED, [$collection]);

        return $collection;
    }

    public function setPublicOptions(int $collectionId, SetPublicOptionsParameters $parameters): Collection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);

        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_ACCESS, [$collection]);

        $collection->setPublicOptions([
            'is_private' => $parameters->isPrivate(),
            'public_enabled' => $parameters->isPublicEnabled(),
            'moderation_contract' => $parameters->isModerationContractEnabled()
        ]);

        $this->collectionRepository->saveCollection($collection);
        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_OPTIONS, [$collection]);

        return $collection;
    }

    public function uploadImage(int $collectionId, UploadImageParameters $parameters): ImageCollection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);

        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_ACCESS, [$collection]);
        $this->avatarService->uploadImage(new CollectionImageStrategy($collection, $this->images, $this->wwwImagesDir), $parameters);
        $this->collectionRepository->saveCollection($collection);
        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_IMAGE_UPLOADED, [$collection]);

        return $collection->getImages();
    }

    public function updateBackdrop(Collection $entity)
    {
        $this->collectionRepository->saveCollection($entity);
    }

    public function protectCollection(int $collectionId): Collection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);
        $collection->enableProtection();

        $this->collectionRepository->saveCollection($collection);

        return $collection;
    }

    public function mainCollection(int $collectionId): Collection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);
        $collection->defineAsMain();

        $this->collectionRepository->saveCollection($collection);

        return $collection;
    }

    public function generateImage(int $collectionId): ImageCollection
    {
        $collection = $this->collectionRepository->getCollectionById($collectionId);

        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_ACCESS, [$collection]);
        $this->avatarService->generateImage(new CollectionImageStrategy($collection, $this->images, $this->wwwImagesDir));
        $this->collectionRepository->saveCollection($collection);
        $this->getEventEmitter()->emit(self::EVENT_COLLECTION_IMAGE_GENERATED, [$collection]);

        return $collection->getImages();
    }

    public function getCollectionById(int $collectionId): Collection
    {
        return $this->collectionRepository->getCollectionById($collectionId);
    }

    public function getCollectionBySID(string $collectionSID): Collection
    {
        return $this->collectionRepository->getCollectionBySID($collectionSID);
    }

    public function getCollectionsById(array $collectionIds): array
    {
        return $this->collectionRepository->getCollectionsById($collectionIds);
    }

    public function loadCollectionsByIds(array $collectionIds)
    {
        $this->collectionRepository->getCollectionsById($collectionIds);
    }
}