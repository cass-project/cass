<?php
namespace Application\Collection\Middleware\Command;

use Cocur\Chain\Chain;
use Application\Collection\Entity\Collection;
use Psr\Http\Message\ServerRequestInterface;

class ListCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $entities = $this->getCollectionService()
            ->read([
                "profile" => $request->getAttribute("profileId")
            ]);

        $entities = Chain::create($entities)
            ->map(function(Collection $collection) {
                return $collection->toJSON();
            })
            ->array
        ;

        return [
            'total' => count($entities),
            'entities'=> $entities
        ];
    }
}