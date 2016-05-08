<?php
namespace Domain\Collection\Middleware\Command;

use Domain\Collection\Middleware\Request\CollectionUpdateRequest;
use Psr\Http\Message\ServerRequestInterface;

class UpdateCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $updateRequest = new CollectionUpdateRequest($request);

        $this->getCollectionService()->update($updateRequest->getParameters());

        return [];
    }
}