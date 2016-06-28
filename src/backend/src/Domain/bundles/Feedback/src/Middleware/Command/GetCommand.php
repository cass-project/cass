<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Exception\FeedbackNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $feedback = $this->feedbackService->getFeedbackById($request->getAttribute('feedbackId'));

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $feedback->toJSON()
                ])
            ;
        } catch(FeedbackNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}