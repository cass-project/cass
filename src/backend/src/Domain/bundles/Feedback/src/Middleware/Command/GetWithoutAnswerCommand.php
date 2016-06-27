<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Entity\Feedback;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetWithoutAnswerCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $feedbackEntities = $this->feedbackService->getFeedbackEntitiesWithoutResponses();

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'entities' => array_map(function(Feedback $feedback) {
                    return $feedback->toJSON();
                }, $feedbackEntities)
            ])
            ->build();
    }
}