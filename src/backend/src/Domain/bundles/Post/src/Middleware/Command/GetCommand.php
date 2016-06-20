<?php
namespace Domain\Post\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $postId = (int) $request->getAttribute('postId');

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $this->postService->getPostById($postId)->toJSON()
            ])
            ->build();
    }
}