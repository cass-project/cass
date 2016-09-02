<?php
namespace CASS\Domain\Bundles\Post\Middleware\Command;
 
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Post\Middleware\Request\EditPostRequest;
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