<?php
namespace CASS\Domain\Bundles\Attachment\Service;

use CASS\Util\FileNameFilter;
use CASS\Util\GenerateRandomString;
use CASS\Domain\Bundles\Attachment\Entity\AttachmentOwner;
use CASS\Domain\Bundles\Attachment\Entity\Attachment;
use CASS\Domain\Bundles\Attachment\Entity\Metadata\AttachmentType;
use CASS\Domain\Bundles\Attachment\Entity\Metadata\File\GenericFileAttachmentType;
use CASS\Domain\Bundles\Attachment\Entity\Metadata\File\ImageAttachmentType;
use CASS\Domain\Bundles\Attachment\Entity\Metadata\File\WebmAttachmentType;
use CASS\Domain\Bundles\Attachment\Entity\Metadata\FileAttachmentType;
use CASS\Domain\Bundles\Attachment\Exception\FileTooBigException;
use CASS\Domain\Bundles\Attachment\Exception\FileTooSmallException;
use CASS\Domain\Bundles\Attachment\LinkMetadata\LinkMetadataFactory;
use CASS\Domain\Bundles\Attachment\Repository\AttachmentRepository;
use CASS\Domain\Bundles\Attachment\Service\FetchResource\Result;
use CASS\Domain\Bundles\Attachment\Source\LocalSource;
use CASS\Domain\Bundles\Attachment\Source\Source;
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