<?php
namespace Domain\Post\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $post = $this->postService->getPostById($request->getAttribute('postId'));

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson($this->postFormatter->format($post))
            ->build();
    }
}