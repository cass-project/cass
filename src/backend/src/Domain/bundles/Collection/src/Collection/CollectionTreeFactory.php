<?php
namespace Domain\Collection\Collection;

class CollectionTreeFactory
{
    public static function createFromJSON(array $json, CollectionTree $tree = null): CollectionTree
    {
        if(! $tree) {
            $tree = new CollectionTree();
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