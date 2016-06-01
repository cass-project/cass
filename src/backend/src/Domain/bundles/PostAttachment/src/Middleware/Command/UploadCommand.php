<?php
namespace Domain\PostAttachment\Middleware\Command;

use Application\Exception\FileNotUploadedException;
use Application\Util\GenerateRandomString;
use Domain\PostAttachment\Entity\PostAttachment\File\ImageAttachmentType;
use Domain\PostAttachment\Exception\FileTooBigException;
use Domain\PostAttachment\Exception\FileTooSmallException;
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

        $imageMaxFilesize = (new ImageAttachmentType())->getMaxFileSizeBytes();
        $imageMinFilesize = (new ImageAttachmentType())->getMinFileSizeBytes();

        if($file->getSize() > $imageMaxFilesize){
            throw new FileTooBigException(sprintf("filesize to big %d > %",$file->getSize(),$imageMaxFilesize));
        }

        if($file->getSize() < $imageMinFilesize){
            throw new FileTooSmallException(sprintf("filesize to small %d > %",$file->getSize(),$imageMinFilesize));
        }

        $imageFileName = sprintf('%s.png', GenerateRandomString::gen(12));

        $entity = $this->postAttachmentService->uploadAttachment(
          $file->getStream()->getMetadata('uri'),
          $imageFileName
        );

        return [
            'entity' => $entity->toJSON()
        ];
    }
}