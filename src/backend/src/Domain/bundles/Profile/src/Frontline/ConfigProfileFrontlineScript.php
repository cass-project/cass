<?php
namespace CASS\Domain\Bundles\Profile\Frontline;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

class ConfigProfileFrontlineScript implements FrontlineScript
{
    public function tags(): array {
        return [
            FrontlineScript::TAG_GLOBAL
        ];
    }

    public function __invoke(): array {
        return [
            'config' => [
                'profile' => [
                    'max_profiles' => ProfileService::MAX_PROFILES_PER_ACCOUNT
                ]
            ]
        ];
    }
}