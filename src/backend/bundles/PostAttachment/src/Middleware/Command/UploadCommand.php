<?php
namespace PostAttachment\Middleware\Command;

use Common\Exception\FileNotUploadedException;
use Common\Exception\NotImplementedException;
use Psr\Http\Message\ServerRequestInterface;

class UploadCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        if($_FILES['file']['error'] !== 0) {
            throw new FileNotUploadedException('Failed to upload file');
        }

        $entity = $this->postAttachmentService->uploadAttachment(
            $_FILES['file']['tmp_name'],
            $_FILES['file']['name']
        );

        return [
            'entity' => $entity->toJSON()
        ];
    }
}