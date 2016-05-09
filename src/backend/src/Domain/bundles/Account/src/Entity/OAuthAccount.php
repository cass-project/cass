<?php
namespace Domain\Account\Entity;

use Application\Util\IdTrait;

/**
 * @Entity(repositoryClass="Domain\Account\Repository\OAuthAccountRepository")
 * @Table(name="oauth_account")
 */
class OAuthAccount
{
    use IdTrait;

    /**
     * @ManyToOne(targetEntity="Domain\Account\Entity\Account",cascade={"persist"})
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

    public function __construct(Account $account) {
        $this->account = $account;
    }

    public function getAccount(): Account {
        return $this->account;
    }

    public function getProvider(): string {
        return $this->provider;
    }

    public function setProvider(string $provider): self {
        $this->provider = $provider;

        return $this;
    }

    public function getProviderAccountId(): string {
        return $this->providerAccountId;
    }

    public function setProviderAccountId(string $providerAccountId): self {
        $this->providerAccountId = $providerAccountId;

        return $this;
    }
}