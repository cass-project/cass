<?php
namespace Domain\Collection\Service;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Repository\CollectionRepository;
use Domain\Collection\Service\Parameters\CollectionService\CollectionCreateParameters;
use Domain\Collection\Service\Parameters\CollectionService\CollectionDeleteParameters;
use Domain\Collection\Service\Parameters\CollectionService\CollectionMoveParameters;
use Domain\Collection\Service\Parameters\CollectionService\CollectionUpdateParameters;

class CollectionService
{
    /** @var CollectionRepository */
    private $collectionRepository;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CollectionRepository $collectionRepository, CurrentAccountService $currentAccountService)
    {
        $this->collectionRepository = $collectionRepository;
        $this->currentAccountService = $currentAccountService;
    }

    public function create(CollectionCreateParameters $collectionCreateParameters) {
        // TODO: Добавить возможность указывать любой профиль
        return $this->collectionRepository->create($this->currentAccountService->getCurrentProfile(), $collectionCreateParameters);
    }

    public function read(array $params=[], $treeLike=false) {
        if (isset($params['id'])) {
            return $this->collectionRepository->getCollectionEntity($params['id']);
        } else {
            $collectionEntities = $this->collectionRepository->getCollections($params);
        }

        if ($treeLike) {
            $collectionEntities = $this->collectionRepository->getCollectionsAsTree($collectionEntities);
        }

        return $collectionEntities;
    }
    
    public function getRootCollections(int $profileId) {
        return $this->collectionRepository->getRootCollections($profileId);
    }

    public function update(CollectionUpdateParameters $collectionUpdateParameters) {
        return $this->collectionRepository->update($collectionUpdateParameters);
    }

    public function delete(CollectionDeleteParameters $collectionDeleteParameters) {
        return $this->collectionRepository->delete($collectionDeleteParameters);
    }

    public function move(CollectionMoveParameters $collectionMoveParameters) {
        return $this->collectionRepository->move($collectionMoveParameters);
    }
}