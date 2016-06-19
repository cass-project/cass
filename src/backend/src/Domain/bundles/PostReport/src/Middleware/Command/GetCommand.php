<?php


namespace Domain\PostReport\Middleware\Command;


use Application\REST\Response\ResponseBuilder;
use Domain\PostReport\Entity\PostReport;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class GetCommand extends Command
{

  public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface{
    try {

      $type   = $request->getAttribute('type');
      $offset = $request->getAttribute('offset');
      $limit  = $request->getAttribute('limit');

      $posts = $this->postReportService->getPostReports($type,$offset,$limit);

      if (count($posts)===0){
        return $responseBuilder
          ->setStatusNotFound()
          ->build();
      }

      return $responseBuilder
        ->setStatusSuccess()
        ->setJson([
                    'entities' => array_map(function(PostReport $postReport){
                      return $postReport->toJSON();
                    },$posts)
                  ])
        ->build();
    }catch(Exception $e){
      return $responseBuilder
        ->setStatusNotFound()
        ->setError($e->getMessage())
        ->build();
    }
  }

}