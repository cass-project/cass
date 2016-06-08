<?php


namespace Domain\Collection\Middleware\Command;


use Domain\Collection\Entity\Collection;
use Domain\Community\Middleware\Request\UploadImageRequest;
use Psr\Http\Message\ServerRequestInterface;

class ImageUploadCommand extends Command
{
  public function run(ServerRequestInterface $request){
    $uploadImageRequest = new UploadImageRequest($request);
    /** @var Collection $collection */
    $collection = $this->collectionService->uploadCollectoinImage($request->getAttribute('collectionId'), $uploadImageRequest->getParameters());

    return [
      'image' => $collection->getImage()->toJSON()
    ];
  }
}