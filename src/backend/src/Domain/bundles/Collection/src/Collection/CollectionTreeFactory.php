<?php
namespace CASS\Domain\Bundles\Collection\Collection;

use CASS\Domain\Bundles\Collection\Collection\CollectionTree\MutableCollectionTree;

class CollectionTreeFactory
{
    public static function createFromJSON(array $json, MutableCollectionTree $tree = null): MutableCollectionTree
    {
        if(!$tree) {
            $tree = new MutableCollectionTree();
        }

        foreach($json as $jsonItem) {
            $item = $tree->attachChild($jsonItem['collection_id'], $jsonItem['position']);

            if(is_array($jsonItem['sub']) && count($jsonItem['sub']) > 0) {
                $item->replaceSub(self::createFromJSON($jsonItem['sub']));
            }
        }

        return $tree;
    }
}