<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Middleware\Request\CreateFeedbackResponseRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateFeedbackResponseCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $feedbackResponseParams = (new CreateFeedbackResponseRequest($request))->getParameters();
        $feedbackResponse = $this->feedbackResponseService->createFeedbackResponse($feedbackResponseParams);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $feedbackResponse->toJSON()
            ])
            ->build();
    }
}