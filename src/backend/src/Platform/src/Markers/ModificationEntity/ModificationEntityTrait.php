<?php
namespace ZEA2\Platform\Markers\ModificationEntity;

trait ModificationEntityTrait
{
    /**
     * @Column(name="date_created_at", type="datetime")
     * @var \DateTime
     */
    private $dateCreatedAt;

    /**
     * @Column(name="last_updated_on", type="datetime")
     * @var \DateTime
     */
    private $lastUpdatedOn;

    private function initModificationEntity()
    {
        $this->dateCreatedAt = new \DateTime();
        $this->lastUpdatedOn = new \DateTime();
    }

    public function getDateCreatedAt(): \DateTime
    {
        return $this->dateCreatedAt;
    }

    public function getLastUpdatedOn(): \DateTime
    {
        return $this->lastUpdatedOn;
    }

    private function markAsUpdated(): self
    {
        $this->lastUpdatedOn = new \DateTime();

        return $this;
    }
}