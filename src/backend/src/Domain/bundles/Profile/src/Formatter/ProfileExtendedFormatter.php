<?php
namespace Domain\Profile\Formatter;

use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Collection\CollectionTree;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Entity\Profile;

final class ProfileExtendedFormatter
{
    /** @var CollectionService */
    private $collectionService;

    public function __construct(CollectionService $collectionService) {
        $this->collectionService = $collectionService;
    }

    public function format(Profile $profile): array {
        $json = $profile->toJSON();
        $json['collections'] = $this->formatCollections($profile->getCollections());

        return $json;
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