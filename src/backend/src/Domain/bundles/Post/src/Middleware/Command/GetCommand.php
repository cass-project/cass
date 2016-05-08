<?php
namespace Domain\Post\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $postId = (int) $request->getAttribute('postId');

        return [
            'entity' => $this->postService->getPostById($postId)->toJSON()
        ];
    }
}