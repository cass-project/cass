<?php
namespace Domain\Collection\Middleware\Command;

use Domain\Collection\Middleware\Request\CollectionMoveRequest;
use Psr\Http\Message\ServerRequestInterface;

class MoveCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $moveRequest = new CollectionMoveRequest($request);

        $this->getCollectionService()->move($moveRequest->getParameters());
        return [];
    }
}