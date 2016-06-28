<?php
namespace Domain\PostAttachment\Middleware\Command;

use Application\Exception\FileNotUploadedException;
use Application\REST\Response\ResponseBuilder;
use Application\Util\GenerateRandomString;
use Domain\PostAttachment\Entity\PostAttachment\File\ImageAttachmentType;
use Domain\PostAttachment\Exception\FileTooBigException;
use Domain\PostAttachment\Exception\FileTooSmallException;
use Domain\PostAttachment\Exception\PostAttachmentFactoryException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;

class UploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            /** @var UploadedFile $file */
            $file = $request->getUploadedFiles()["file"];

            if($file->getError() !== 0) {
                throw new FileNotUploadedException('Failed to upload file');
            }

            $imageMaxFileSize = (new ImageAttachmentType())->getMaxFileSizeBytes();
            $imageMinFileSize = (new ImageAttachmentType())->getMinFileSizeBytes();

            if($file->getSize() > $imageMaxFileSize){
                throw new FileTooBigException(sprintf("filesize to big %d > %",$file->getSize(),$imageMaxFileSize));
            }

            if($file->getSize() < $imageMinFileSize){
                throw new FileTooSmallException(sprintf("filesize to small %d > %",$file->getSize(),$imageMinFileSize));
            }

            $imageFileName = sprintf('%s.png', GenerateRandomString::gen(12));

            $entity = $this->postAttachmentService->uploadAttachment(
                $file->getStream()->getMetadata('uri'),
                $imageFileName
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $entity->toJSON()
                ]);
        } catch(FileTooBigException  $e) {
            $responseBuilder
                ->setStatus(409)
                ->setError($e);
        } catch(FileTooSmallException $e) {
            $responseBuilder
                ->setStatus(409)
                ->setError($e);
        } catch(PostAttachmentFactoryException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}