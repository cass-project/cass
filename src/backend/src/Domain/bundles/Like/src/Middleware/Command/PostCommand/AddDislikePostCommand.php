<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\PostCommand;

use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use CASS\Domain\Bundles\Post\Exception\PostNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class AddDislikePostCommand extends PostCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $postId = $request->getAttribute('postId');
            $post = $this->postService->getPostById($postId);

            $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($post);

            $this->likePostService->addDislike($post, $attitude);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $this->postFormatter->format($post),
                ]);

        } catch(AttitudeAlreadyExistsException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusConflict();
        } catch(PostNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        } catch(\Exception $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }

}