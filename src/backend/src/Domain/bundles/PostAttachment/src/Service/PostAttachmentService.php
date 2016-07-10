<?php
namespace Domain\PostAttachment\Service;

use Application\Util\FileNameFilter;
use Domain\OpenGraph\Parser\OpenGraphParser;
use Domain\Post\Entity\Post;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Entity\PostAttachment\AttachmentType;
use Domain\PostAttachment\Entity\PostAttachment\File\GenericFileAttachmentType;
use Domain\PostAttachment\Entity\PostAttachment\File\ImageAttachmentType;
use Domain\PostAttachment\Entity\PostAttachment\File\WebmAttachmentType;
use Domain\PostAttachment\Entity\PostAttachment\FileAttachmentType;
use Domain\PostAttachment\Entity\PostAttachment\Link\GenericLinkAttachmentType;
use Domain\PostAttachment\Exception\FileTooBigException;
use Domain\PostAttachment\Exception\FileTooSmallException;
use Domain\PostAttachment\LinkMetadata\LinkMetadataFactory;
use Domain\PostAttachment\Repository\PostAttachmentRepository;
use League\Flysystem\FilesystemInterface;

class PostAttachmentService
{
    /** @var FilesystemInterface */
    private $fileSystem;

    /** @var PostAttachmentRepository */
    private $postAttachmentRepository;

    /** @var FetchResourceService */
    private $fetchResourceService;
    
    /** @var LinkMetadataFactory */
    private $linkMetadataFactory;

    /**
     * PostAttachmentService constructor.
     * @param FilesystemInterface $fileSystem
     * @param PostAttachmentRepository $postAttachmentRepository
     * @param FetchResourceService $fetchResourceService
     * @param LinkMetadataFactory $linkMetadataFactory
     */
    public function __construct(
        FilesystemInterface $fileSystem,
        PostAttachmentRepository $postAttachmentRepository,
        FetchResourceService $fetchResourceService,
        LinkMetadataFactory $linkMetadataFactory
    ) {
        $this->fileSystem = $fileSystem;
        $this->postAttachmentRepository = $postAttachmentRepository;
        $this->fetchResourceService = $fetchResourceService;
        $this->linkMetadataFactory = $linkMetadataFactory;
    }

    public function createLinkAttachment(Post $post, string $url, string $resource, array $metadata): PostAttachment
    {
        $attachmentType = $this->factoryLinkAttachmentType($url, $metadata);

        $postAttachment = new PostAttachment($attachmentType->getCode());
        $postAttachment->attachToPost($post);
        $postAttachment->setAttachment([
            'url' => $url,
            'resource' => $resource,
            'metadata' => $metadata
        ]);

        $this->postAttachmentRepository->createPostAttachment($postAttachment);

        return $postAttachment;
    }
    
    public function linkAttachment(string $url): PostAttachment
    {
        if(strpos($url, 'http') === false) {
            $url = 'http://'.$url;
        }

        $result = $this->fetchResourceService->fetchResource($url);
        $linkMetadata = $this->linkMetadataFactory->createLinkMetadata($url, $result->getContentType(), $result->getContent());
        $metadata = array_merge([
            'url' => $linkMetadata->getURL(),
            'resource' => $linkMetadata->getResourceType(),
            'metadata' => $linkMetadata->toJSON()
        ]);

        $attachmentType = $this->factoryLinkAttachmentType($url, $metadata);

        $postAttachment = new PostAttachment($attachmentType->getCode());
        $postAttachment->setAttachment($metadata);

        $this->postAttachmentRepository->createPostAttachment($postAttachment);

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

        $subDirectory = $postAttachmentEntity->getId();
        $storagePath = $subDirectory . '/' . $desiredFileName;

        if($this->fileSystem->write($storagePath, file_get_contents($tmpFile)) === false) {
            throw new \Exception('Failed to copy uploaded file');
        }

        $postAttachmentEntity->setAttachment([
            'file' => [
                'public_path' => '/dist/storage/post/attachment/' . $subDirectory . '/' . $desiredFileName,
                'storage_path' => $storagePath
            ]
        ]);

        if($attachmentType instanceof AttachmentTypeExtension) {
            $postAttachmentEntity->mergeAttachment($attachmentType->extend($postAttachmentEntity));
        }

        $this->postAttachmentRepository->savePostAttachment($postAttachmentEntity);

        return $postAttachmentEntity;
    }

    public function setAttachments(Post $post, array $attachmentIds)
    {
        $this->postAttachmentRepository->assignAttachmentsToPost($post, $attachmentIds);
    }

    public function addAttachment(Post $post, PostAttachment $attachment): PostAttachment
    {
        $attachment->attachToPost($post);

        $post->getAttachments()->add($attachment);

        $this->postAttachmentRepository->savePostAttachment($attachment);

        return $attachment;
    }

    public function getPostAttachmentById(int $postAttachmentId)
    {
        return $this->postAttachmentRepository->getPostAttachmentById($postAttachmentId);
    }

    public function getAttachmentsOfPost(int $postId): array
    {
        /** @var PostAttachment[] $result */
        $result = $this->postAttachmentRepository->getAttachmentsOfPost($postId);

        return $result;
    }

    private function factoryFileAttachmentType(string $tmpFile): AttachmentType
    {
        if(ImageAttachmentType::detect($tmpFile)) {
            return new ImageAttachmentType();
        } else if(WebmAttachmentType::detect($tmpFile)) {
            return new WebmAttachmentType();
        } else {
            return new GenericFileAttachmentType();
        }
    }

    private function factoryLinkAttachmentType(string $url, array $metadata): AttachmentType
    {
        return new GenericLinkAttachmentType();
    }

    private function validateFileSize(string $tmpFile, FileAttachmentType $attachmentType)
    {
        $fileSize = filesize($tmpFile);

        if($fileSize > $attachmentType->getMaxFileSizeBytes()) {
            throw new FileTooBigException(sprintf('File should be less than %d bytes', $attachmentType->getMaxFileSizeBytes()));
        } else if($fileSize < $attachmentType->getMinFileSizeBytes()) {
            throw new FileTooSmallException(sprintf('File should be more than %d bytes', $attachmentType->getMinFileSizeBytes()));
        }
    }
}