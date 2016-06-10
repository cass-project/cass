<?php
namespace Domain\Collection\Middleware\Command;

use Application\Exception\BadCommandCallException;
use Application\REST\Response\ResponseBuilder;
use Domain\Collection\Entity\Collection;
use Domain\Collection\Middleware\Request\CreateCollectionRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $collection = $this->createCollection($request);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $collection->toJSON()
            ])
            ->build();
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
            throw new BadCommandCallException('Unknown collection owner');
        }
    }
}