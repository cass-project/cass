<?php
namespace Profile\Entity;

/**
 * Class Profile
 * @Entity(repositoryClass="Data\Repository\AccountRepository")
 * @Table(name="profile")
 */
class Profile
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $accountId;

    public function __construct(int $accountId)
    {
        $this->accountId = $accountId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccountId(): int
    {
        return $this->accountId;
    }

    public function setAccountId(int $accountId)
    {
        $this->accountId = $accountId;
    }
}