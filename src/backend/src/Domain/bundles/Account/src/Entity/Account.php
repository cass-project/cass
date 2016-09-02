<?php
namespace CASS\Domain\Account\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\Entity\JSONMetadata\JSONMetadataEntity;
use CASS\Util\Entity\JSONMetadata\JSONMetadataEntityTrait;
use CASS\Util\Entity\SIDEntity\SIDEntity;
use CASS\Util\Entity\SIDEntity\SIDEntityTrait;
use CASS\Util\GenerateRandomString;
use CASS\Util\JSONSerializable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use CASS\Domain\Profile\Entity\Profile;
use CASS\Domain\Profile\Entity\Profile\Greetings;
use CASS\Domain\Profile\Exception\NoCurrentProfileException;
use CASS\Domain\Profile\Exception\ProfileNotFoundException;

/**
 * @Entity(repositoryClass="CASS\Domain\Account\Repository\AccountRepository")
 * @Table(name="account")
 */
class Account implements JSONSerializable, IdEntity, SIDEntity, JSONMetadataEntity
{
    use IdTrait;
    use SIDEntityTrait;
    use JSONMetadataEntityTrait;

    /**
     * @Column(type="string", name="api_key")
     * @var string
     */
    private $apiKey;

    /**
     * @OneToMany(targetEntity="CASS\Domain\Profile\Entity\Profile", mappedBy="account", cascade={"all"})
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
        $this->regenerateAPIKey();
        $this->regenerateSID();
    }

    public function regenerateAPIKey(): string
    {
        $this->apiKey = GenerateRandomString::gen(12);

        return $this->apiKey;
    }

    public function equals(Account $compare): bool 
    {
        return $compare->getId() === $this->getId();
    }

    public function toJSON(): array
    {
        return [
            'id' => $this->isPersisted() ? $this->getId() : '#NEW_ACCOUNT',
            'email' => $this->getEmail(),
            'disabled' => [
                'is_disabled' => $this->isDisabled(),
                'reason' => $this->isDisabled() ? $this->getDisabledReason() : null
            ],
            'delete_request' => [
                'has' => $this->hasDeleteAccountRequest(),
                'date' => $this->hasDeleteAccountRequest()
                    ? $this->getDateAccountDeleteRequested()->format(\DateTime::RFC2822)
                    : null
            ],
            'profiles' => array_map(function(Profile $profile) {
                return $profile->toJSON();
            }, $this->getProfiles()->toArray()),
            'metadata' => $this->getMetadata()
        ];
    }

    public function getProfiles(): Collection
    {
        return $this->profiles;
    }

    public function getCurrentProfile(): Profile
    {
        foreach ($this->getProfiles() as $profile) {
            /** @var Profile $profile */
            if ($profile->isCurrent()) {
                return $profile;
            }
        }

        throw new NoCurrentProfileException(sprintf('No current profile available for account ID: %d', $this->isPersisted() ? $this->getId() : 'NEW_INSTANCE'));
    }

    public function getProfileWithId(int $profileId): Profile
    {
        /** @var Profile $profile */
        foreach($this->getProfiles() as $profile) {
            if($profile->getId() === $profileId) {
                return $profile;
            }
        }

        throw new ProfileNotFoundException(sprintf('Profile with ID `%s` not found', $profile->getIdNoFall()));
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
        return $this->apiKey;
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
        if (!$this->isDisabled()) {
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