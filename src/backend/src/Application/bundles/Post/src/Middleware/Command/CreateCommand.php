<?php
namespace Application\Post\Middleware\Command;

use Application\Post\Middleware\Request\CreatePostRequest;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $createPostParameters = (new CreatePostRequest($request))->getParameters();

        // TODO: Is current profile validator

        $post = $this->postService->createPost($createPostParameters);

        return [
            'entity' => $post->toJSON()
        ];
    }
}