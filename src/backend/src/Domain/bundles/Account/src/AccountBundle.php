<?php
namespace Domain\Account;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
use Domain\Account\Scripts\ProcessAccountDeleteRequestsScript;

class AccountBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            'delete_account_request_days' => function() {
                return ProcessAccountDeleteRequestsScript::DAYS_TO_ACCEPT_REQUEST;
            }
        ];
    }
}