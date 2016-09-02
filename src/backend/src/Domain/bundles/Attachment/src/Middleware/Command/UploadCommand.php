<?php
namespace CASS\Domain\Bundles\Attachment\Middleware\Command;

use CASS\Application\Exception\FileNotUploadedException;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Util\GenerateRandomString;
use CASS\Domain\Bundles\Attachment\Exception\FileTooBigException;
use CASS\Domain\Bundles\Attachment\Exception\FileTooSmallException;
use CASS\Domain\Bundles\Attachment\Exception\AttachmentFactoryException;
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

            $entity = $this->attachmentService->uploadAttachment(
                $file->getStream()->getMetadata('uri'),
                $filename
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $entity->toJSON(),
                ]);
        } catch(FileTooBigException  $e) {
            $responseBuilder
                ->setStatus(409)
                ->setError($e);
        } catch(FileTooSmallException $e) {
            $responseBuilder
                ->setStatus(409)
                ->setError($e);
        } catch(AttachmentFactoryException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}