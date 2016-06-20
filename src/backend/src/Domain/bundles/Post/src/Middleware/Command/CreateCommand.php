<?php
namespace Domain\Post\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Post\Middleware\Request\CreatePostRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $createPostParameters = (new CreatePostRequest($request))->getParameters();

        $post = $this->postService->createPost($createPostParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $post->toJSON()
            ])
            ->build();
    }
}