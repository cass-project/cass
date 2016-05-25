<?php
namespace Domain\Profile;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
use Domain\Profile\Service\ProfileService;

class ProfileBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            'config' => [
                'profile' => function() {
                    return [
                        'max_profiles' => ProfileService::MAX_PROFILES_PER_ACCOUNT
                    ];
                }
            ]
        ];
    }
}