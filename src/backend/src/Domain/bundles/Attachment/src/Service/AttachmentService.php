<?php
namespace Domain\Attachment\Service;

use Application\Util\FileNameFilter;
use Application\Util\GenerateRandomString;
use Domain\Attachment\Entity\AttachmentOwner;
use Domain\Attachment\Entity\Attachment;
use Domain\Attachment\Entity\Metadata\AttachmentType;
use Domain\Attachment\Entity\Metadata\File\GenericFileAttachmentType;
use Domain\Attachment\Entity\Metadata\File\ImageAttachmentType;
use Domain\Attachment\Entity\Metadata\File\WebmAttachmentType;
use Domain\Attachment\Entity\Metadata\FileAttachmentType;
use Domain\Attachment\Exception\FileTooBigException;
use Domain\Attachment\Exception\FileTooSmallException;
use Domain\Attachment\LinkMetadata\LinkMetadataFactory;
use Domain\Attachment\Repository\AttachmentRepository;
use Domain\Attachment\Service\FetchResource\Result;
use Domain\Attachment\Source\LocalSource;
use Domain\Attachment\Source\Source;
use League\Flysystem\FilesystemInterface;

class AttachmentService
{
    /** @var FilesystemInterface */
    private $fileSystem;

    /** @var AttachmentRepository */
    private $attachmentRepository;

    /** @var FetchResourceService */
    private $fetchResourceService;

    /** @var LinkMetadataFactory */
    private $linkMetadataFactory;

    /** @var string */
    private $wwwDir;

    public function __construct(
        FilesystemInterface $fileSystem,
        AttachmentRepository $attachmentRepository,
        FetchResourceService $fetchResourceService,
        LinkMetadataFactory $linkMetadataFactory,
        string $wwwDir
    )
    {
        $this->fileSystem = $fileSystem;
        $this->attachmentRepository = $attachmentRepository;
        $this->fetchResourceService = $fetchResourceService;
        $this->linkMetadataFactory = $linkMetadataFactory;
        $this->wwwDir = $wwwDir;
    }

    public function linkAttachment(string $url, Result $result, Source $source): Attachment
    {
        $linkMetadata = $this->linkMetadataFactory->createLinkMetadata($url, $result->getContentType(),
            $result->getContent());

        $metadata = [
            'url' => $linkMetadata->getURL(),
            'resource' => $linkMetadata->getResourceType(),
            'metadata' => $linkMetadata->toJSON(),
            'source' => array_merge(['source' => $source->getCode()], $source->toJSON()),
        ];

        $attachment = new Attachment();
        $attachment->setMetadata($metadata);

        $this->attachmentRepository->createAttachment($attachment);

        return $attachment;
    }

    public function uploadAttachment(string $tmpFile, string $desiredFileName): Attachment
    {
        $desiredFileName = FileNameFilter::filter($desiredFileName);

        $attachmentType = $this->factoryFileAttachmentType($tmpFile);

        if($attachmentType instanceof FileAttachmentType) {
            $this->validateFileSize($tmpFile, $attachmentType);
        }

        $subDirectory = join('/', str_split(GenerateRandomString::gen(12), 2));
        $storagePath = $subDirectory . '/' . $desiredFileName;
        $publicPath = sprintf('%s/%s/%s', $this->wwwDir, $subDirectory, $desiredFileName);

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

    public function attach(AttachmentOwner $owner, Attachment $attachment): Attachment
    {
        $attachment->attach($owner);

        $this->attachmentRepository->saveAttachment($attachment);

        return $attachment;
    }

    public function destroy(Attachment $attachment)
    {
        $this->attachmentRepository->deleteAttachment([$attachment]);
    }

    public function getById(int $id): Attachment
    {
        return $this->attachmentRepository->getById($id);
    }

    public function getManyByIds(array $attachmentIds): array
    {
        return $this->attachmentRepository->getManyByIds($attachmentIds);
    }

    private function factoryFileAttachmentType(string $tmpFile): AttachmentType
    {
        if(ImageAttachmentType::detect($tmpFile)) {
            return new ImageAttachmentType();
        }else if(WebmAttachmentType::detect($tmpFile)) {
            return new WebmAttachmentType();
        }else{
            return new GenericFileAttachmentType();
        }
    }

    private function validateFileSize(string $tmpFile, FileAttachmentType $attachmentType)
    {
        $fileSize = filesize($tmpFile);

        if($fileSize > $attachmentType->getMaxFileSizeBytes()) {
            throw new FileTooBigException(sprintf('File should be less than %d bytes',
                $attachmentType->getMaxFileSizeBytes()));
        }else if($fileSize < $attachmentType->getMinFileSizeBytes()) {
            throw new FileTooSmallException(sprintf('File should be more than %d bytes',
                $attachmentType->getMinFileSizeBytes()));
        }
    }
}