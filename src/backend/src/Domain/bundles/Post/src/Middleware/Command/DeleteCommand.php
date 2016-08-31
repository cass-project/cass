<?php
namespace Domain\Post\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $postId = (int) $request->getAttribute('postId');

        $this->postService->deletePost($postId);

        return $responseBuilder
            ->setStatusSuccess()
            ->build();
    }
}