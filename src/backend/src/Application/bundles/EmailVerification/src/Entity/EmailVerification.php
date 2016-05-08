<?php
namespace Application\EmailVerification\Entity;

use Application\Account\Entity\Account;
use Application\Common\REST\JSONSerializable;
use DateTime;

/**
 * @Entity(repositoryClass="Application\EmailVerification\Repository\EmailVerificationRepository")
 * @Table(name="email_verification")
 */
class EmailVerification /* implements JSONSerializable */
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Application\Account\Entity\Application\Account")
     * @JoinColumn(name="for_account_id", referencedColumnName="id")
     * @var Account
     */
    private $forAccount;

    /**
     * @Column(type="datetime", name="date_requested")
     * @var DateTime
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
     * @var DateTime
     */
    private $dateConfirmation;

    public function __construct(Account $forAccount) {
        $this->forAccount = $forAccount;
        $this->dateRequested = new \DateTime();
    }

    public function getId(): int {
        return $this->id;
    }

    public function isPersisted() {
        return $this->id !== null;
    }

    public function getForAccount(): Account {
        return $this->forAccount;
    }

    public function getDateRequested(): DateTime {
        return $this->dateRequested;
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
        $this->dateConfirmation = new DateTime();
        $this->isConfirmed = true;
    }
}