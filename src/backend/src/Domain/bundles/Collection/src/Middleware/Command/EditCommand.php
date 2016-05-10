<?php
namespace Domain\Collection\Middleware\Command;

use Application\Exception\NotImplementedException;
use Domain\Collection\Middleware\Request\EditCollectionRequest;
use Psr\Http\Message\ServerRequestInterface;

class EditCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $collectionId = $request->getAttribute('collectionId');
        $parameters = (new EditCollectionRequest($request))->getParameters();

        $collection = $this->collectionService->editCollection($collectionId, $parameters);

        return [
            'entity' => $collection->toJSON()
        ];
    }
}