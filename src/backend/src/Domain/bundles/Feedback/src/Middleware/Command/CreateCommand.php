<?php
namespace CASS\Domain\Feedback\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Feedback\Exception\EmptyDescriptionException;
use CASS\Domain\Feedback\Exception\InvalidFeedbackTypeException;
use CASS\Domain\Feedback\Middleware\Request\CreateFeedbackRequest;
use CASS\Domain\Profile\Exception\ProfileNotFoundException;
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
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}