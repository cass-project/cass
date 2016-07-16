<?php
namespace Domain\IM\Parameters;

final class SendMessageParameters
{
    /** @var int */
    private $sourceProfileId;

    /** @var int */
    private $targetProfileId;

    /** @var string */
    private $message;

    /** @var int[] */
    private $attachmentIds;

    public function __construct(
        $sourceProfileId,
        $targetProfileId,
        $message, array
        $attachmentIds
    ) {
        $this->sourceProfileId = $sourceProfileId;
        $this->targetProfileId = $targetProfileId;
        $this->message = $message;
        $this->attachmentIds = $attachmentIds;
    }

    public function getSourceProfileId(): int
    {
        return $this->sourceProfileId;
    }

    public function getTargetProfileId(): int
    {
        return $this->targetProfileId;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getAttachmentIds(): array
    {
        return array_filter($this->attachmentIds, function($input) {
            return is_int($input);
        });
    }
}