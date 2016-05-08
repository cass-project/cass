<?php
namespace Application\Collection\Middleware\Command;

use Application\Collection\Middleware\Request\CollectionCreateRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $createRequest = new CollectionCreateRequest($request);

        $collection = $this->getCollectionService()->create($createRequest->getParameters());

        return [
            'entity' => $collection->toJSON()
        ];
    }
}