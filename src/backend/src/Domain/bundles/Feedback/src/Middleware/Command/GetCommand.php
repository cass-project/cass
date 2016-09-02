<?php
namespace CASS\Domain\Bundles\Feedback\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Feedback\Exception\FeedbackNotFoundException;
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