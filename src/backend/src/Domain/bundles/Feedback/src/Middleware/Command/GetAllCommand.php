<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Entity\Feedback;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAllCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $limit = $request->getAttribute('limit');
            $offset = $request->getAttribute('offset');
            $profileId = $this->currentAccountService->getCurrentProfile()->getId();

            $feedbackEntities = $this->feedbackService->getAllFeedbackEntities($profileId, $limit, $offset);
            
            return $responseBuilder
                ->setStatusSuccess()
                ->setJson(['entities' => array_map(function(Feedback $feedback) {
                    return $feedback->toJSON();
                }, $feedbackEntities)]);
        } catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e->getMessage());
        } catch(\Exception $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e->getMessage());
        }

        return $responseBuilder->build();
    }

}