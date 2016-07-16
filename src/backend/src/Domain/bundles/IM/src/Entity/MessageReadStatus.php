<?php
namespace Domain\IM\Entity;

use Zend\I18n\Validator\DateTime;

class MessageReadStatus
{
    /** @var bool */
    private $isRead = false;

    /** @var DateTime */
    private $dateRead;

    public function __construct(bool $isRead, DateTime $dateRead = null)
    {
        $this->isRead = $isRead;

        if($isRead) {
            $this->dateRead = $dateRead;
        }
    }

    public function toMongoBSON(): array
    {
        $result = [
            'is_read' => $this->isRead()
        ];

        if($this->isRead()) {
            $result['date_read'] = $this->getDateRead()->format(\DateTime::RFC2822);
            $result['_obj'] = $this->getDateRead();
        }

        return $result;
    }

    public function markAsRead()
    {
        $this->isRead = true;
        $this->dateRead = new \DateTime();
    }

    public function isRead(): bool
    {
        return $this->isRead;
    }

    public function getDateRead(): \DateTime
    {
        return $this->dateRead;
    }
}