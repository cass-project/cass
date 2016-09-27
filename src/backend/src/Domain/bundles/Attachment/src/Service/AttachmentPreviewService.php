<?php
namespace CASS\Domain\Bundles\Attachment\Service;

use CASS\Domain\Bundles\Attachment\LinkMetadata\LinkMetadata;
use CASS\Domain\Bundles\Attachment\LinkMetadata\Types\WebmLinkMetadata;
use CASS\Domain\Bundles\Attachment\Source\Source;

final class AttachmentPreviewService
{
    /** @var string */
    private $attachmentsRealPath;

    public function __construct(string $attachmentsRealPath)
    {
        $this->attachmentsRealPath = $attachmentsRealPath;
    }

    public function generatePreview(
        string $dir,
        string $file,
        Source $source,
        LinkMetadata $metadata
    ): string {
        if($metadata instanceof WebmLinkMetadata) {
            return $this->generateWebmPreview($dir, $file);
        }else{
            throw new \Exception('Unknown how to generate preview');
        }
    }

    public function generateWebmPreview(string $dir, string $file)
    {
        $ffSource = sprintf('%s/%s/%s', $this->attachmentsRealPath, $dir, $file);
        $ffDestination = sprintf('%s/%s/preview.png', $this->attachmentsRealPath, $dir);

        exec(sprintf('ffmpeg -y  -i %s -f mjpeg -vframes 1 -ss 1 %s', $ffSource, $ffDestination));

        return 'preview.png';
    }
}