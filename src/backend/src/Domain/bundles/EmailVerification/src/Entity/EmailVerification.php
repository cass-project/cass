<?php
namespace CASS\Domain\EmailVerification\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdTrait;
use CASS\Util\JSONSerializable;
use CASS\Domain\Account\Entity\Account;

/**
 * @Entity(repositoryClass="CASS\Domain\EmailVerification\Repository\EmailVerificationRepository")
 * @Table(name="email_verification")
 */
class EmailVerification implements IdEntity, JSONSerializable
{
    use IdTrait;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Account\Entity\CASS\Domain\Account")
     * @JoinColumn(name="for_account_id", referencedColumnName="id")
     * @var Account
     */
    private $forAccount;

    /**
     * @Column(type="datetime", name="date_requested")
     * @var \DateTime
     */
    private $dateRequested;

    /**
     * @Column(type="string")
     * @var string
     */
    private $token;

    /**
     * @Column(type="boolean", name="is_confirmed")
     * @var bool
     */
    private $isConfirmed = false;

    /**
     * @Column(type="datetime", name="date_confirmed")
     * @var \DateTime
     */
    private $dateConfirmation;

    public function __construct(Account $forAccount) {
        $this->forAccount = $forAccount;
        $this->dateRequested = new \DateTime();
    }

    public function toJSON(): array {
        $result = [
            'id' => $this->getId(),
            'for_account' => [
                'id' => $this->getForAccount()->getId()
            ],
            'date_requested' => $this->getDateRequested()->format(\DateTime::RFC2822),
            'token' => $this->getToken(),
            'is_confirmed' => $this->isConfirmed(),
        ];

        if ($this->isConfirmed()) {
            $result['date_confirmed'] = $this->getDateConfirmed()->format(\DateTime::RFC2822);
        }

        return $result;
    }

    public function getForAccount(): Account {
        return $this->forAccount;
    }

    public function getDateRequested(): \DateTime {
        return $this->dateRequested;
    }

    public function getDateConfirmed(): \DateTime {
        return $this->dateConfirmation;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function setToken(string $token): self {
        $this->token = $token;
        return $this;
    }

    public function isConfirmed(): bool {
        return $this->isConfirmed;
    }

    public function confirm() {
        $this->dateConfirmation = new \DateTime();
        $this->isConfirmed = true;
    }
}