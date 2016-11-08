<?php
namespace CASS\Domain\Bundles\Account\Entity;

use ZEA2\Platform\Markers\IdEntity\IdEntity;
use ZEA2\Platform\Markers\IdEntity\IdEntityTrait;
use CASS\Util\JSONSerializable;

/**
 * @Entity(repositoryClass="CASS\Domain\Bundles\Account\Repository\AccountAppAccessRepository")
 * @Table(name="account_app_access")
 */
final class AccountAppAccess implements IdEntity, JSONSerializable
{
    use IdEntityTrait;

    /**
     * @ManyToOne(targetEntity="CASS\Domain\Bundles\Account\Entity\Account",cascade={"persist"})
     * @JoinColumn(name="account_id", referencedColumnName="id")
     * @var Account
     */
    private $account;

    /**
     * @Column(type="boolean", name="app_admin")
     * @var boolean
     */
    private $appAdmin = false;

    /**
     * @Column(type="boolean", name="app_reports")
     * @var boolean
     */
    private $appReports = false;

    /**
     * @Column(type="boolean", name="app_feedback")
     * @var boolean
     */
    private $appFeedback = false;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function toJSON(): array
    {
        return [
            'account' => $this->account->toJSON(),
            'apps' => [
                'admin' => $this->appAdmin,
                'reports' => $this->appReports,
                'feedback' => $this->appFeedback,
            ]
        ];
    }

    public function allowAdmin()
    {
        $this->appAdmin = true;
    }

    public function isAdminAllowed(): bool
    {
        return $this->appAdmin;
    }
    
    public function denyAdmin()
    {
        $this->appAdmin = false;
    }
    
    public function allowFeedback()
    {
        $this->appFeedback = true;
    }
    
    public function isFeedbackAllowed(): bool 
    {
        return $this->appFeedback;
    }
    
    public function denyFeedback()
    {
        $this->appFeedback = false;
    }
    
    public function allowReports()
    {
        $this->appReports = true;
    }
    
    public function isReportsAllowed(): bool 
    {
        return $this->appReports;
    }
    
    public function denyReports()
    {
        $this->appReports = false;
    }
}

final class AccessControl
{
    /** @var bool */
    private $app;

    public function __construct(&$app)
    {
        $this->app = $app;
    }

    public function allow()
    {
        $this->app = true;
    }

    public function deny()
    {
        $this->app = false;
    }

    public function isAllowed(): bool
    {
        return $this->app;
    }
}