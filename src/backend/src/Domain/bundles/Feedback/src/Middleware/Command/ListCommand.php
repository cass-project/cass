<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Application\Util\QueryBoolean;
use Domain\Feedback\Entity\Feedback;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $qp = $request->getQueryParams();
            
            $profileId = $this->currentAccountService->getCurrentProfile()->getId();

            $options = [
                'seek' => [
                    'limit' => $request->getAttribute('limit'),
                    'offset' => $request->getAttribute('offset')
                ],
                'filter' => []
            ];

            if($qp['read']) {
                $options['filter']['read'] = QueryBoolean::extract($qp['read']);
            }

            if($qp['answer']) {
                $options['filter']['answer'] = QueryBoolean::extract($qp['answer']);
            }

            $feedbackEntities = $this->feedbackService->getFeedbackEntities($profileId, $options);
            
            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entities' => array_map(function(Feedback $feedback) {
                        return $feedback->toJSON();
                    }, $feedbackEntities)
                ]);
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