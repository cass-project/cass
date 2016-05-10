<?php
namespace Domain\Collection\Middleware\Command;

use Application\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $collectionId = $request->getAttribute('collectionId');

        $this->collectionService->deleteCollection($collectionId);

        return [];
    }
}