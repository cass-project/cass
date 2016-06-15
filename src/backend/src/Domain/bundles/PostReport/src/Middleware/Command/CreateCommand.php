<?php


namespace Domain\PostReport\Middleware\Command;


use Application\REST\Response\ResponseBuilder;
use Domain\PostReport\Middleware\Request\CreatePostReportRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateCommand extends Command
{
  public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface{
    try {

      $createPostReportParameters = (new CreatePostReportRequest())->getParameters();


      $this->postReportService->createPostReport($createPostReportParameters);


      return $responseBuilder
        ->setStatusSuccess()
        ->setJson([
                    'entity' => $profile->toJSON()
                  ])
        ->build();
    }catch(Exception $e){
      throw new Exception($e->getMessage());
    }
  }
}