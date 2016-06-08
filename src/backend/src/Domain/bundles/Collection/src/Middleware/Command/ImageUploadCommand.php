<?php


namespace Domain\Collection\Middleware\Command;


use Application\REST\Response\ResponseBuilder;
use Application\Util\Scripts\AvatarUploadScriptException;
use Domain\Collection\Entity\Collection;
use Domain\Community\Middleware\Request\UploadImageRequest;
use Psr\Http\Message\ServerRequestInterface;

class ImageUploadCommand extends Command
{
  public function run(ServerRequestInterface $request,ResponseBuilder $responseBuilder){
    try {
      $uploadImageRequest = new UploadImageRequest($request);
      /** @var Collection $collection */
      $collection = $this->collectionService->uploadCollectoinImage($request->getAttribute('collectionId'), $uploadImageRequest->getParameters());

      return $responseBuilder->setStatusSuccess()
                             ->setJson([
                                         'image' => $collection->getImage()
                                                               ->toJSON()
                                       ]
                             )->build();
    } catch(AvatarUploadScriptException $e) {
      return $responseBuilder
        ->setError($e)
        ->setStatus(422)
        ->build();
    }
  }
}