<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Exception\EmptyDescriptionException;
use Domain\Feedback\Exception\InvalidFeedbackTypeException;
use Domain\Feedback\Middleware\Request\CreateFeedbackRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $feedback = $this->feedbackService->createFeedback(
                (new CreateFeedbackRequest($request))->getParameters()
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $feedback->toJSON()
                ]);
        }catch(InvalidFeedbackTypeException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusBadRequest();
        }catch(EmptyDescriptionException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusBadRequest();
        }

        return $responseBuilder->build();
    }
}