<?php
namespace Domain\PostAttachment\Middleware\Command;

use Application\Exception\FileNotUploadedException;
use Application\Util\GenerateRandomString;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;

class UploadCommand extends Command
{
    public function run(ServerRequestInterface $request) {


        /** @var UploadedFile $file */
        $file = $request->getUploadedFiles()["file"];


        if($file->getError() !== 0) {
            throw new FileNotUploadedException('Failed to upload file');
        }

        if($file->getSize()> 10000000){}


        $imageFileName = sprintf('%s.png', GenerateRandomString::gen(12));
        $publicPath = sprintf('/public/storage/post-attachment/%s',  $imageFileName);

        $entity = $this->postAttachmentService->uploadAttachment(
          $file->getStream()->getMetadata('uri'),
          $publicPath
        );

        return [
            'entity' => $entity->toJSON()
        ];
    }
}