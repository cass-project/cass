<?php
namespace Data\Entity;

/**
 * @Entity(repositoryClass="Data\Repository\OAuthAccountRepository")
 * @Table(name="oauth_account")
 */
class OAuthAccount
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Data\Entity\Account",cascade={"persist"})
     * @JoinColumn(name="account_id", referencedColumnName="id")
     */
    private $account;

    /**
     * @Column(type="string")
     * @var string
     */
    private $provider;

    /**
     * @Column(type="integer",name="provider_account_id")
     * @var string
     */
    private $providerAccountId;

    public function hasId()
    {
        return $this->id !== null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

        return $this;
    }

    public function getProviderAccountId(): string
    {
        return $this->providerAccountId;
    }

    public function setProviderAccountId(string $providerAccountId): self
    {
        $this->providerAccountId = $providerAccountId;

        return $this;
    }
}