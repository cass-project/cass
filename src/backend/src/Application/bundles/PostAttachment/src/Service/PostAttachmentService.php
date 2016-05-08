<?php
namespace Application\PostAttachment\Service;

use Application\Common\Util\FileNameFilter;
use Application\Post\Entity\Post;
use Application\PostAttachment\Entity\PostAttachment;
use Application\PostAttachment\Entity\PostAttachment\AttachmentType;
use Application\PostAttachment\Entity\PostAttachment\File\GenericFileAttachmentType;
use Application\PostAttachment\Entity\PostAttachment\File\ImageAttachmentType;
use Application\PostAttachment\Entity\PostAttachment\File\WebmAttachmentType;
use Application\PostAttachment\Entity\PostAttachment\FileAttachmentType;
use Application\PostAttachment\Entity\PostAttachment\Link\GenericLinkAttachmentType;
use Application\PostAttachment\Exception\FileTooBigException;
use Application\PostAttachment\Exception\FileTooSmallException;
use Application\PostAttachment\Repository\PostAttachmentRepository;
use Application\PostAttachment\Service\AttachmentTypeExtension;

class PostAttachmentService
{
    /** @var string */
    private $uploadDir;

    /** @var PostAttachmentRepository */
    private $postAttachmentRepository;


    public function __construct(
        string $storageDir,
        string $uploadDir,
        PostAttachmentRepository $postAttachmentRepository
    ) {
        $this->uploadDir = $storageDir.'/'.$uploadDir;
        $this->postAttachmentRepository = $postAttachmentRepository;
    }

    public function createLinkAttachment(Post $post, string $url, array $metadata): PostAttachment
    {
        $attachmentType = $this->factoryLinkAttachmentType($url, $metadata);

        $postAttachment = new PostAttachment($attachmentType->getCode());
        $postAttachment->attachToPost($post);
        $postAttachment->setAttachment([
            'url' => $url,
            'metadata' => $metadata
        ]);

        $this->postAttachmentRepository->savePostAttachment($postAttachment);

        return $postAttachment;
    }

    public function uploadAttachment(string $tmpFile, string $desiredFileName): PostAttachment
    {
        $desiredFileName = FileNameFilter::filter($desiredFileName);

        $attachmentType = $this->factoryFileAttachmentType($tmpFile);

        if($attachmentType instanceof FileAttachmentType) {
            $this->validateFileSize($tmpFile, $attachmentType);
        }

        $postAttachmentEntity = $this->postAttachmentRepository->makePostAttachmentEntity($attachmentType->getCode());

        $directory = $this->uploadDir;
        $subDirectory = $postAttachmentEntity->getId();
        $resultDir = $directory.'/'.$subDirectory;

        if(mkdir($resultDir) === false) {
            throw new \Exception('Failed to create subdirectory');
        }

        if(move_uploaded_file($tmpFile, $resultDir.'/'.$desiredFileName) === false) {
            throw new \Exception('Failed to move uploaded file');
        }

        $postAttachmentEntity->setAttachment([
            'file' => [
                'public' => '/public/storage/post/attachment/'.$subDirectory.'/'.$desiredFileName,
                'storage' => $resultDir.'/'.$desiredFileName
            ]
        ]);

        if($attachmentType instanceof AttachmentTypeExtension) {
            $postAttachmentEntity->mergeAttachment($attachmentType->extend($postAttachmentEntity));
        }

        $this->postAttachmentRepository->savePostAttachment($postAttachmentEntity);

        return $postAttachmentEntity;
    }
    
    public function setAttachments(Post $post, array $attachmentIds) {
        $this->postAttachmentRepository->assignAttachmentsToPost($post, $attachmentIds);
    }

    private function factoryFileAttachmentType(string $tmpFile): AttachmentType {
        if(ImageAttachmentType::detect($tmpFile)) {
            return new ImageAttachmentType();
        }else if(WebmAttachmentType::detect($tmpFile)) {
            return new WebmAttachmentType();
        }else{
            return new GenericFileAttachmentType();
        }
    }

    private function factoryLinkAttachmentType(string $url, array $metadata): AttachmentType {
        // TODO:: validate link
        return new GenericLinkAttachmentType();
    }

    private function validateFileSize(string $tmpFile, FileAttachmentType $attachmentType) {
        $fileSize = filesize($tmpFile);

        if($fileSize > $attachmentType->getMaxFileSizeBytes()) {
            throw new FileTooBigException(sprintf('File should be less than %d bytes', $attachmentType->getMaxFileSizeBytes()));
        }else if ($fileSize < $attachmentType->getMinFileSizeBytes()){
            throw new FileTooSmallException(sprintf('File should be more than %d bytes', $attachmentType->getMinFileSizeBytes()));
        }
    }
}