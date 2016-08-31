<?php
namespace Domain\Post\Middleware\Command;
 
use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Post\Middleware\Request\EditPostRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EditCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $editPostParameters = (new EditPostRequest($request))->getParameters();

        $post = $this->postService->editPost($editPostParameters);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $this->postFormatter->format($post),
            ])
            ->build();
    }
}