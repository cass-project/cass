<?php
namespace Collection\Middleware\Command;

use Collection\Middleware\Request\CollectionMoveRequest;
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