<?php
namespace Domain\Feedback\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Domain\Feedback\Exception\FeedbackHasNoAnswerException;
use Domain\Feedback\Exception\FeedbackNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MarkAsReadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $this->feedbackService->markAsRead($request->getAttribute('feedbackId'));

            $responseBuilder
                ->setStatusSuccess();
        } catch(FeedbackNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        } catch (FeedbackHasNoAnswerException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}