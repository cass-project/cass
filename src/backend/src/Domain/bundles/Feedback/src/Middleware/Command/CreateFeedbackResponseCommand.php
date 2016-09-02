<?php
namespace CASS\Domain\Bundles\Feedback\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Feedback\Middleware\Request\CreateFeedbackResponseRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateFeedbackResponseCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $feedbackResponseParams = (new CreateFeedbackResponseRequest($request))->getParameters();
        $feedbackResponse = $this->feedbackService->answer($feedbackResponseParams);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entity' => $feedbackResponse->toJSON()
            ])
            ->build();
    }
}