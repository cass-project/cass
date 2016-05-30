<?php
namespace Domain\Post\Middleware\Command;

use Domain\Post\Middleware\Request\CreatePostRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $createPostParameters = (new CreatePostRequest($request))->getParameters();
        
        $post = $this->postService->createPost($createPostParameters);

        return [
            'entity' => $post->toJSON()
        ];
    }
}