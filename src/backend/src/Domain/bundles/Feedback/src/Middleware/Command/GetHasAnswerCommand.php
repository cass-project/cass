<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Exception\FeedbackNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetHasAnswerCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $feedbackId = $request->getAttribute('feedbackId');

            $feedbackResponses = $this->feedbackService->getFeedbackResponse($feedbackId);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entities' => array_map(function(FeedbackResponse $feedbackResponse) {
                        return $feedbackResponse->toJSON();
                    }, $feedbackResponses)
                ]);
        } catch(FeedbackNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e->getMessage());
        }

        return $responseBuilder->build();
    }
}