<?php
namespace Domain\IM\Service\LastMessageService;

use CASS\Util\JSONSerializable;

final class LastMessageServiceResult implements JSONSerializable
{
    /** @var bool */
    private $has;

    /** @var \DateTime */
    private $date;

    /** @var string */
    private $message;

    public function __construct(bool $has, \DateTime $date = null, string $message = null)
    {
        $this->has = $has;
        $this->date = $date;
        $this->message = $message;
    }

    public function toJSON(): array
    {
        if($this->has()) {
            return [
                'has' => $this->has(),
                'date' => $this->getDate()->format(\DateTime::RFC2822),
                'message' => $this->getMessage(),
            ];
        }else{
            return [
                'has' => $this->has(),
            ];
        }
    }

    public function has(): bool
    {
        return $this->has;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}