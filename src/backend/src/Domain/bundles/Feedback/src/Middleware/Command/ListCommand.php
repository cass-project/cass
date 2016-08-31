<?php
namespace Domain\Feedback\Middleware\Command;

use CASS\Application\Exception\SeekException;
use CASS\Application\REST\Response\ResponseBuilder;
use CASS\Util\QueryBoolean;
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

            $options = [
                'profileId' => null,
                'seek' => [
                    'limit' => $request->getAttribute('limit'),
                    'offset' => $request->getAttribute('offset')
                ],
                'filter' => []
            ];

            if(isset($qp['profileId'])) {
                $options['profileId'] = (int) $qp['profileId'];
            }else{
                $options['profileId'] = $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId();
            }

            if(isset($qp['read'])) {
                $options['filter']['read'] = QueryBoolean::extract($qp['read']);
            }

            if(isset($qp['answer'])) {
                $options['filter']['answer'] = QueryBoolean::extract($qp['answer']);
            }

            $feedbackEntities = $this->feedbackService->getFeedbackEntities($options);
            
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
                ->setError($e);
        } catch(SeekException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e);
        }

        return $responseBuilder->build();
    }

}