<?php
namespace CASS\Domain\Bundles\IM\Parameters;

final class SendMessageParameters
{
    /** @var string */
    private $message;

    /** @var int[] */
    private $attachmentIds;

    public function __construct(
        $message, array
        $attachmentIds
    ) {
        $this->message = $message;
        $this->attachmentIds = $attachmentIds;
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