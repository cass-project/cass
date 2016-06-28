<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Exception\FeedbackNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $this->feedbackService->deleteFeedback($request->getAttribute('feedbackId'));

            $responseBuilder
                ->setStatusSuccess();
        } catch(FeedbackNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e->getMessage());
        }
        
        return $responseBuilder->build();
    }
}