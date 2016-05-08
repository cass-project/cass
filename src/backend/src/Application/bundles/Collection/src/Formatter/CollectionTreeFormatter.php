<?php
namespace Application\Collection\Formatter;

use Application\Collection\Entity\Collection;

class CollectionTreeFormatter
{
    public function format(array $collections, array &$carry = [], int $depth = 0): array
    {
        /** @var $collections Collection[] */
        foreach($collections as $collection) {
            $carry[] = [
                'id' => $collection->getId(),
                'parent_id' => $collection->hasParent()
                    ? $collection->getParent()->getId()
                    : 0,
                'theme_id' => $collection->hasTheme()
                    ? $collection->getTheme()->getId()
                    : 0,
                'title' => $collection->getTitle(),
                'description' => $collection->getDescription(),
                'position' => $collection->getPosition(),
                'depth' => $depth
            ];

            if($collection->hasChildren()) {
                $this->format($collection->getChildren()->toArray(), $carry, $depth+1);
            }
        }

        return $carry;
    }
}