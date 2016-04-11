<?php
namespace Collection\Middleware\Command;

use Collection\Middleware\Request\CollectionCreateRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $createRequest = new CollectionCreateRequest($request);

        return [];
    }
}