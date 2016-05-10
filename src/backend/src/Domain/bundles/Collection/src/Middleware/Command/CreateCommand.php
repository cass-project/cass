<?php
namespace Domain\Collection\Middleware\Command;

use Application\Exception\CommandNotFoundException;
use Application\Exception\NotImplementedException;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Middleware\Request\CreateCollectionRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $collection = $this->createCollection($request);

        return [
            'entity' => $collection->toJSON()
        ];
    }

    private function createCollection(ServerRequestInterface $request): Collection
    {
        $owner = $request->getAttribute('owner');
        $parameters = (new CreateCollectionRequest($request))->getParameters();

        if($owner === 'community') {
            $communityId = $request->getAttribute('communityId');

            return $this->collectionService->createCommunityCollection(
                $communityId,
                $parameters
            );
        }else if($owner === 'profile') {
            return $this->collectionService->createProfileCollection($parameters);
        }else{
            throw new CommandNotFoundException('Unknown collection owner');
        }
    }
}