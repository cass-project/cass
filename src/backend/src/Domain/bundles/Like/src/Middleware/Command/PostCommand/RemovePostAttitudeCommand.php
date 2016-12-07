<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\PostCommand;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeNotFoundException;
use CASS\Domain\Bundles\Post\Exception\PostNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class RemovePostAttitudeCommand extends PostCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $postId = $request->getAttribute('postId');
            $post = $this->postService->getPostById($postId);

            // устанавливаем владельца
            $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($post);

            // устанавливаем свойства
            $attitude->setResource($post);
            $attitude = $this->likePostService->getAttitude($attitude);

            switch($attitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_LIKE:
                    $this->likePostService->removeLike($post, $attitude);
                    break;
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    $this->likePostService->removeDislike($post, $attitude);
                    break;
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $this->postFormatter->format($post),
                ]);

        } catch(AttitudeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
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