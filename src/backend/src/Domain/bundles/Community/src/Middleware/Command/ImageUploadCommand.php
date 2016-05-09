<?php
namespace Domain\Community\Middleware\Command;

use Domain\Community\Middleware\Request\UploadImageRequest;
use Psr\Http\Message\ServerRequestInterface;

final class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $uploadImageRequest = new UploadImageRequest($request);
        $community = $this->communityService->uploadCommunityImage($request->getAttribute('communityId'), $uploadImageRequest->getParameters());

        return [
            'image' => $community->getImage()->toJSON()
        ];
    }
}