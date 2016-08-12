<?php
namespace Domain\PostAttachment\Service;

use Application\Util\FileNameFilter;
use Application\Util\GenerateRandomString;
use Application\Util\Seek;
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
use Domain\PostAttachment\Service\FetchResource\Result;
use Domain\PostAttachment\Source\LocalSource;
use Domain\PostAttachment\Source\Source;
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
    
    public function linkAttachment(string $url, Result $result, Source $source): PostAttachment
    {
        $linkMetadata = $this->linkMetadataFactory->createLinkMetadata($url, $result->getContentType(), $result->getContent());

        $metadata = [
            'url' => $linkMetadata->getURL(),
            'resource' => $linkMetadata->getResourceType(),
            'metadata' => $linkMetadata->toJSON(),
            'source' => array_merge(['source' => $source->getCode()], $source->toJSON())
        ];

        $postAttachment = new PostAttachment();
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

        $subDirectory = GenerateRandomString::gen(12);
        $storagePath = $subDirectory . '/' . $desiredFileName;
        $publicPath = '/dist/storage/post/attachment/' . $subDirectory . '/' . $desiredFileName;

        $finfo = new \finfo(FILEINFO_MIME);
        $content = file_get_contents($tmpFile);
        $contentType = $finfo->buffer($content);

        if($this->fileSystem->write($storagePath, $content) === false) {
            throw new \Exception('Failed to copy uploaded file');
        }
        
        $result = new Result($publicPath, $content, $contentType);
        $source = new LocalSource($publicPath, $storagePath);

        return $this->linkAttachment($publicPath, $result, $source);
    }

    public function setAttachments(Post $post, array $attachmentIds)
    {
        $this->postAttachmentRepository->assignAttachmentsToPost($post, $attachmentIds);
    }

    public function attach(Post $post, PostAttachment $attachment): PostAttachment
    {
        $attachment->attachToPost($post);

        $this->postAttachmentRepository->savePostAttachment($attachment);

        return $attachment;
    }

    public function destroy(PostAttachment $postAttachment)
    {
        $this->postAttachmentRepository->deletePostAttachments([$postAttachment]);
    }

    public function getPostAttachmentById(int $postAttachmentId): PostAttachment
    {
        return $this->postAttachmentRepository->getPostAttachmentById($postAttachmentId);
    }
    
    public function getAttachmentsByIds(array $attachmentIds): array
    {
        return $this->postAttachmentRepository->getAttachmentByIds($attachmentIds);
    }

    public function getAttachmentsByCriteria(array $types, Seek $seek): array
    {
        return $this->postAttachmentRepository->findBy(['attachmentType' => $types], NULL, $seek->getLimit(), $seek->getOffset());
    }

    public function getTotalCountAttachments(array $types): int
    {
        return $this->postAttachmentRepository->getTotalCountAttachments($types);
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

    public function updatePostAttachment(PostAttachment $postAttachment){
        return $this->postAttachmentRepository->savePostAttachment($postAttachment);
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