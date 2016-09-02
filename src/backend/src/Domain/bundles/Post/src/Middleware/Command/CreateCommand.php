<?php
namespace CASS\Domain\Post\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Post\Exception\UnknownPostTypeException;
use CASS\Domain\Post\Middleware\Request\CreatePostRequest;
use CASS\Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $createPostParameters = (new CreatePostRequest($request))->getParameters();

            $post = $this->postService->createPost($createPostParameters);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $this->postFormatter->format($post),
                ]);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }catch(UnknownPostTypeException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusBadRequest();
        }

        return $responseBuilder->build();
    }
}