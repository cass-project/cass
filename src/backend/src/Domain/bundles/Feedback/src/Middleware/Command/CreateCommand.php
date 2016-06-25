<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Middleware\Request\CreateFeedbackRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
  public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
  {

    $createParameters = (new CreateFeedbackRequest($request))->getParameters();

    $feedback = $this->feedbackService->createFeedback($createParameters);

    return $responseBuilder
      ->setStatusSuccess()
      ->setJson(
        [
         'entity'=> $feedback->toJSON()])
      ->build()
    ;
  }
}