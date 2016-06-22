<?php
namespace Domain\Profile\Formatter;

use Domain\Collection\Collection\CollectionItem;
use Domain\Collection\Collection\CollectionTree;
use Domain\Collection\Service\CollectionService;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;

final class ProfileExtendedFormatter
{
    /** @var CollectionService */
    private $collectionService;

    public function __construct(CollectionService $collectionService) {
        $this->collectionService = $collectionService;
    }

    public function format(Profile $profile): array {
        return [
            'profile' => $profile->toJSON(),
            'collections' => $this->formatCollections($profile->getCollections())
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