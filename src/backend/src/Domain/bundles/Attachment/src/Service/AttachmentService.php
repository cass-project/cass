<?php
namespace CASS\Domain\Bundles\Attachment\Service;

use CASS\Domain\Bundles\Attachment\LinkMetadata\Properties\HasPreview;
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

    /** @var AttachmentPreviewService */
    private $previewService;

    /** @var string */
    private $wwwDir;

    /** @var bool */
    private $generatePreviews = false;

    public function __construct(
        FilesystemInterface $fileSystem,
        AttachmentRepository $attachmentRepository,
        FetchResourceService $fetchResourceService,
        LinkMetadataFactory $linkMetadataFactory,
        AttachmentPreviewService $attachmentPreviewService,
        string $wwwDir,
        bool $generatePreviews
    )
    {
        $this->fileSystem = $fileSystem;
        $this->attachmentRepository = $attachmentRepository;
        $this->fetchResourceService = $fetchResourceService;
        $this->linkMetadataFactory = $linkMetadataFactory;
        $this->previewService = $attachmentPreviewService;
        $this->wwwDir = $wwwDir;
        $this->generatePreviews = $generatePreviews;
    }

    public function linkAttachment(
        string $url,
        string $dir,
        string $file,
        Result $result,
        Source $source): Attachment
    {
        $linkMetadata = $this->linkMetadataFactory->createLinkMetadata(
            $url,
            $result->getContentType(),
            $result->getContent()
        );

        if($this->generatePreviews && ($linkMetadata instanceof HasPreview)) {
            $preview = $this->previewService->generatePreview($dir, $file, $source, $linkMetadata);

            $linkMetadata->setPreview(
                sprintf('%s/%s', $dir, $preview),
                sprintf('%s/%s/%s', $this->wwwDir, $dir, $preview)
            );
        }

        $metadata = [
            'url' => $linkMetadata->getURL(),
            'resource' => $linkMetadata->getResourceType(),
            'metadata' => $linkMetadata->toJSON(),
            'version' => $linkMetadata->getVersion(),
            'source' => array_merge(['source' => $source->getCode()], $source->toJSON()),
        ];

        $attachment = new Attachment($linkMetadata->getTitle(), $linkMetadata->getDescription());
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

        return $this->linkAttachment($publicPath, $subDirectory, $desiredFileName, $result, $source);
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

    public function specifyTitleAndDescriptionFor(Attachment $attachment, string $title, string $description)
    {
        $attachment
            ->setTitle($title)
            ->setDescription($description);

        $this->attachmentRepository->saveAttachment($attachment);
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