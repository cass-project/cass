<?php
namespace Domain\Post\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $postId = (int) $request->getAttribute('postId');

        $this->postService->deletePost($postId);

        return [];
    }
}