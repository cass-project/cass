<?php
namespace CASS\Domain\Contact\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\Entity\SIDEntity\SIDEntity;
use CASS\Util\Entity\SIDEntity\SIDEntityTrait;
use CASS\Util\JSONSerializable;
use CASS\Domain\Contact\Exception\ContactIsNotPermanentException;
use CASS\Domain\Profile\Entity\Profile;

/**
 * @Entity(repositoryClass="CASS\Domain\Contact\Repository\ContactRepository")
 * @Table(name="contact")
 */
class Contact implements IdEntity, SIDEntity, JSONSerializable
{
    use IdTrait, SIDEntityTrait;

    /**
     * @Column(type="datetime", name="date_created_on")
     * @var \DateTime
     */
    private $dateCreatedOn;

    /**
     * @Column(type="datetime", name="date_permanent_on")
     * @var \DateTime
     */
    private $datePermanentOn;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Profile\Entity\Profile")
     * @JoinColumn(name="source_profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $sourceProfile;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Profile\Entity\Profile")
     * @JoinColumn(name="target_profile_id", referencedColumnName="id")
     * @var Profile
     */
    private $targetProfile;

    public function __construct(Profile $sourceProfile, Profile $targetProfile)
    {
        $this->sourceProfile = $sourceProfile;
        $this->targetProfile = $targetProfile;
        $this->dateCreatedOn = new \DateTime();
        $this->regenerateSID();
    }

    public function toJSON(): array
    {
        $permanent = [
            'is' => $this->isPermanent()
        ];

        if($this->isPermanent()) {
            $permanent['date'] = $this->getDatePermanentOn()->format(\DateTime::RFC2822);
        }

        return [
            'id' => $this->getId(),
            'sid' => $this->getSID(),
            'date_created_on' => $this->getDateCreatedOn()->format(\DateTime::RFC2822),
            'permanent' => $permanent,
            'source_profile' => $this->getSourceProfile()->toJSON(),
            'target_profile' => $this->getTargetProfile()->toJSON(),
        ];
    }

    public function isPermanent(): bool
    {
        return $this->datePermanentOn instanceof \DateTime;
    }

    public function setPermanent(): self
    {
        $this->datePermanentOn = new \DateTime();
        
        return $this;
    }
    
    public function getDateCreatedOn(): \DateTime
    {
        return $this->dateCreatedOn;
    }

    public function getDatePermanentOn(): \DateTime
    {
        if(! $this->isPermanent()) {
            throw new ContactIsNotPermanentException(sprintf('Contact `%s` is not permanent', $this->getIdNoFall()));
        }

        return $this->datePermanentOn;
    }

    public function getSourceProfile(): Profile
    {
        return $this->sourceProfile;
    }

    public function getTargetProfile(): Profile
    {
        return $this->targetProfile;
    }
}