<?php
namespace Domain\PostAttachment\Middleware\Command;

use Application\Exception\FileNotUploadedException;
use Application\REST\Response\ResponseBuilder;
use Application\Util\GenerateRandomString;
use Domain\PostAttachment\Exception\FileTooBigException;
use Domain\PostAttachment\Exception\FileTooSmallException;
use Domain\PostAttachment\Exception\PostAttachmentFactoryException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;

class UploadCommand extends Command
{
    const AUTO_GENERATE_FILE_NAME_LENGTH = 8;

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            /** @var UploadedFile $file */
            $file = $request->getUploadedFiles()["file"];
            $filename = $file->getClientFilename();

            if(! strlen($filename)) {
                $filename = GenerateRandomString::gen(self::AUTO_GENERATE_FILE_NAME_LENGTH);
            }

            if($file->getError() !== 0) {
                throw new FileNotUploadedException('Failed to upload file');
            }

            $entity = $this->postAttachmentService->uploadAttachment(
                $file->getStream()->getMetadata('uri'),
                $filename
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