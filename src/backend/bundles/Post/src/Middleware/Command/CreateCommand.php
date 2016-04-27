<?php
namespace Post\Middleware\Command;

use Common\Exception\NotImplementedException;
use Post\Middleware\Request\CreatePostRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $createPostParameters = (new CreatePostRequest($request))->getParameters();

        throw new NotImplementedException;
    }
}