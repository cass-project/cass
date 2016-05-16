<?php
namespace Domain\Account\Entity;

use Application\Util\IdTrait;
use Application\Util\JSONSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Exception\NoCurrentProfileException;

/**
 * @Entity(repositoryClass="Domain\Account\Repository\AccountRepository")
 * @Table(name="account")
 */
class Account implements JSONSerializable
{
    use IdTrait;

    /**
     * @OneToMany(targetEntity="Domain\Profile\Entity\Profile", mappedBy="account")
     * @var Collection
     */
    private $profiles;

    /**
     * @Column(type="string")
     * @var string
     */
    private $email;

    /**
     * @Column(type="string")
     * @var string
     */
    private $password;

    /**
     * @Column(type="boolean", name="is_disabled")
     * @var bool
     */
    private $isDisabled = false;

    /**
     * @Column(type="string", name="disabled_reason")
     * @var string
     */
    private $disabledReason;

    /**
     * @Column(type="boolean", name="is_email_verified")
     * @var bool
     */
    private $isEmailVerified = false;

    /**
     * @Column(type="boolean", name="is_account_delete_requested")
     * @var bool
     */
    private $isAccountDeleteRequested = false;

    /**
     * @Column(type="datetime", name="date_account_delete_request")
     * @var \DateTime|null
     */
    private $dateAccountDeleteRequest;

    public function __construct()
    {
        $this->profiles = new ArrayCollection();
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'disabled' => [
                'is_disabled' => $this->isDisabled(),
                'reason' => $this->isDisabled() ? $this->getDisabledReason() : null
            ],
            'delete_request' => [
                'has' => $this->hasDeleteAccountRequest(),
                'date' =>  $this->hasDeleteAccountRequest()
                    ? $this->getDateAccountDeleteRequested()->format(\DateTime::RFC822)
                    : null
            ]
        ];
    }

    public function addProfile(Profile $profile){
        $this->profiles[] = $profile;
        return $this;
    }

    public function getProfiles(): Collection
    {
        return $this->profiles;
    }
    
    public function getCurrentProfile(): Profile
    {
        foreach($this->getProfiles() as $profile) {
            /** @var Profile $profile */
            if($profile->isCurrent()) {
                return $profile;
            }
        }
        
        throw new NoCurrentProfileException(sprintf('No current profile available for account ID: %d', $this->isPersisted() ? $this->getId() : 'NEW_INSTANCE'));
    }

    public function isYoursProfile(Profile $profile)
    {
        return $this->profiles->contains($profile);
    }

    public function hasAnyProfile(): bool
    {
        return $this->profiles->count() > 0;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getAPIKey()
    {
        return $this->password;
    }

    public function disableAccount(string $reason)
    {
        $this->isDisabled = true;
        $this->disabledReason = $reason;
    }

    public function unlockAccount()
    {
        $this->isDisabled = false;
        $this->disabledReason = '';
    }

    public function setAsEmailVerified()
    {
        $this->isEmailVerified = true;
    }

    public function isEmailVerified(): bool
    {
        return $this->isEmailVerified;
    }

    public function isDisabled(): bool
    {
        return $this->isDisabled;
    }

    public function getDisabledReason(): string
    {
        if(!$this->isDisabled()) {
            throw new \Exception('Account is not disabled');
        }

        return $this->isDisabled;
    }


    public function requestAccountDelete()
    {
        $this->isAccountDeleteRequested = true;
        $this->dateAccountDeleteRequest = new \DateTime();
    }

    public function cancelAccountRequestDelete()
    {
        $this->isAccountDeleteRequested = false;
        $this->dateAccountDeleteRequest = null;
    }

    public function hasDeleteAccountRequest(): bool
    {
        return $this->isAccountDeleteRequested;
    }

    public function getDateAccountDeleteRequested(): \DateTime
    {
        return $this->dateAccountDeleteRequest;
    }
}