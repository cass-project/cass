<?php
namespace Post\Middleware\Command;

use Common\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $postId = (int) $request->getAttribute('postId');

        throw new NotImplementedException;
    }
}