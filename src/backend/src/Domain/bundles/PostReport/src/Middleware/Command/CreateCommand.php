<?php


namespace Domain\PostReport\Middleware\Command;


use Application\REST\Response\ResponseBuilder;
use Domain\PostReport\Middleware\Request\CreatePostReportRequest;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateCommand extends Command
{
  public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface{
    try {
      $createPostReportParameters = (new CreatePostReportRequest($request))->getParameters();
      $postReport = $this->postReportService->createPostReport($createPostReportParameters);

      return $responseBuilder
        ->setStatusSuccess()
        ->setJson([
                    'entity' => $postReport->toJSON()
                  ])
        ->build();
    }catch(ProfileNotFoundException $e){
      return $responseBuilder
        ->setStatusNotFound()
        ->setError($e->getMessage())
        ->build();
    }
  }
}