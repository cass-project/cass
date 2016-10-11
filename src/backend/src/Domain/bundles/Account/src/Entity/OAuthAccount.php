<?php
namespace CASS\Domain\Bundles\Account\Entity;

use CASS\Util\Entity\IdEntity\IdEntity;
use CASS\Util\Entity\IdEntity\IdEntityTrait;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Account\Repository\OAuthAccountRepository")
 * @Table(name="oauth_account")
 */
class OAuthAccount implements IdEntity
{
    use IdEntityTrait;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Account\Entity\Account",cascade={"persist"})
     * @JoinColumn(name="account_id", referencedColumnName="id")
     * @var Account
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

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function getAccount(): Account
    {
        return $this->account;
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