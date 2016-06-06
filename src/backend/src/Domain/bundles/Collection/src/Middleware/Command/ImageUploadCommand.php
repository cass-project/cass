<?php


namespace Domain\Collection\Middleware\Command;


use Domain\Community\Middleware\Request\UploadImageRequest;
use Psr\Http\Message\ServerRequestInterface;

class ImageUploadCommand extends Command
{
  public function run(ServerRequestInterface $request){
    $uploadImageRequest = new UploadImageRequest($request);
    $collection = $this->collectionService->uploadCommunityImage($request->getAttribute('collectionId'), $uploadImageRequest->getParameters());

    return [
      'image' => $collection->getImage()->toJSON()
    ];
  }
}