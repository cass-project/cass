<?php
namespace CASS\Domain\Community\Formatter;

use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Collection\Collection\CollectionItem;
use CASS\Domain\Collection\Collection\CollectionTree;
use CASS\Domain\Collection\Service\CollectionService;
use CASS\Domain\Community\Entity\Community;

final class CommunityExtendedFormatter
{
    /** @var CollectionService */
    private $collectionService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(
        CollectionService $collectionService,
        CurrentAccountService $currentAccountService
    ) {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
    }

    public function format(Community $community)
    {
        $isOwn = false;
        
        if($this->currentAccountService->isAvailable()) {
            $isOwn = $this->currentAccountService->getCurrentAccount()->equals($community->getOwner());
        }
        
        return [
            'community' => $community->toJSON(),
            'collections' => $this->formatCollections($community->getCollections()),
            'is_own' => $isOwn,
        ];
    }

    private function formatCollections(CollectionTree $tree): array {
        return array_map(function(CollectionItem $item) {
            $json = $this->collectionService->getCollectionById($item->getCollectionId())->toJSON();

            if($item->hasChildren()) {
                $json['children'] = $this->formatCollections($item->sub());
            }else{
                $json['children'] = [];
            }

            return $json;
        }, $tree->getItems());
    }
}