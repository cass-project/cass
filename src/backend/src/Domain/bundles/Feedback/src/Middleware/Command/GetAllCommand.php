<?php
namespace Domain\Feedback\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Feedback\Entity\Feedback;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAllCommand extends Command
{
  public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface{

    try{
      $limit = $request->getAttribute('limit');
      $offset = $request->getAttribute('offset');
      $profileId = $this->currentAccountService->getCurrentProfile()->getId();

      $feedbacks =$this->feedbackService->getAllFeedbacks($profileId, $limit, $offset);

      if(count($feedbacks) === 0){
        return $responseBuilder
          ->setStatusNotFound()
          ->build();
      }

      return $responseBuilder
        ->setStatusSuccess()
        ->setJson(['entities'=> array_map(function(Feedback $feedback){
          return $feedback->toJSON();
        },$feedbacks) ])
        ->build();
    }catch (ProfileNotFoundException $e){

      print_r("profile  ");
      die();
      return $responseBuilder
        ->setStatusNotFound()
        ->setError($e->getMessage())
        ->build();
    }catch(\Exception $e){
      return $responseBuilder
        ->setStatusNotFound()
        ->setError($e->getMessage())
        ->build();
    }
  }

}