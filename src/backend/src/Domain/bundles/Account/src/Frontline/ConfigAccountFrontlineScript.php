<?php
namespace CASS\Domain\Bundles\Account\Frontline;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Domain\Bundles\Account\Scripts\ProcessAccountDeleteRequestsScript;

class ConfigAccountFrontlineScript implements FrontlineScript
{
    public function tags(): array
    {
        return [
            FrontlineScript::TAG_GLOBAL
        ];
    }

    public function __invoke(): array
    {
        return [
            'config' => [
                'account' => [
                    'delete_account_request_days' => ProcessAccountDeleteRequestsScript::DAYS_TO_ACCEPT_REQUEST
                ]
            ]
        ];
    }
}