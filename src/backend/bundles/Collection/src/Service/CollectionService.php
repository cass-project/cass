<?php
namespace Collection\Service;

use Auth\Service\CurrentAccountService;
use Collection\Repository\CollectionRepository;
use Collection\Service\Parameters\CollectionService\CollectionCreateParameters;
use Collection\Service\Parameters\CollectionService\CollectionDeleteParameters;
use Collection\Service\Parameters\CollectionService\CollectionUpdateParameters;
use Doctrine\Common\Collections\Collection;

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
        /**
         * @author: hck
         * @DOTO: Добавить возможность указывать любой профиль
         */
        return $this->collectionRepository->create($this->currentAccountService->getCurrentProfile(), $collectionCreateParameters);
    }

    public function update(CollectionUpdateParameters $collectionUpdateParameters) {
        return $this->collectionRepository->update($collectionUpdateParameters);
    }

    public function delete(CollectionDeleteParameters $collectionDeleteParameters) {
        return $this->collectionRepository->delete($collectionDeleteParameters);
    }

}