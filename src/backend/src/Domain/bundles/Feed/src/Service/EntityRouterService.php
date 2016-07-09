<?php
namespace Domain\Feed\Service;

use Cocur\Chain\Chain;
use Domain\Feed\Exception\EntityIsNotPersistedException;
use Domain\Feed\Source\Source;

final class EntityRouterService
{
    /** @var FeedService */
    private $feedService;

    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    public function create(Entity $entity, array $sources)
    {
        $this->doWith($entity, $sources, function(Source $source) use ($entity) {
            $collection = $this->feedService->getCollection($source);
            $collection->insert($entity->toJSON());
        });
    }

    public function replace(Entity $entity, array $sources)
    {
        $this->doWith($entity, $sources, function(Source $source) use ($entity) {
            $collection = $this->feedService->getCollection($source);
            $collection->update([
                'id' => $entity->getId()
            ], $entity->toJSON());
        });
    }

    public function delete(Entity $entity, array $sources)
    {
        $this->doWith($entity, $sources, function(Source $source) use ($entity) {
            $collection = $this->feedService->getCollection($source);
            $collection->remove([
                'id' => $entity->getId()
            ]);
        });
    }

    private function doWith(Entity $entity, array $sources, Callable $callback)
    {
        if(!$entity->isPersisted()) {
            throw new EntityIsNotPersistedException(sprintf('Entity is not persisted'));
        }

        Chain::create($sources)
            ->filter(function(Source $source) use ($entity) {
                return $source->test($entity);
            })
            ->map($callback);
    }
}