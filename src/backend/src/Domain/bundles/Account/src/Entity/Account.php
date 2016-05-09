<?php
namespace Domain\Account\Entity;

use Application\Util\JSONSerializable;
use Doctrine\ORM\PersistentCollection;
use Domain\Profile\Entity\Profile;

/**
 * Class Domain\Account
 * @package Data\Entity
 * @Entity(repositoryClass="Domain\Account\Repository\AccountRepository")
 * @Table(name="account")
 */
class Account implements JSONSerializable
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @OneToMany(targetEntity="Domain\Profile\Entity\Profile", mappedBy="account")
     * @var PersistentCollection
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

    public function toJSON(): array
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'disabled' => [
                'is_disabled' => $this->isDisabled(),
                'reason' => $this->isDisabled() ? $this->getDisabledReason() : null
            ]
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProfiles(): PersistentCollection
    {
        return $this->profiles;
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
            throw new \Exception('Domain\Account is not disabled');
        }

        return $this->isDisabled;
    }
}