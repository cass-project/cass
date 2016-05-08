<?php
namespace Application\Auth;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\Bootstrap\Bundle\FrontlineBundleInjectable;
use Application\Common\Bootstrap\Bundle\GenericBundle;
use DI\Container;
use Application\Frontline\Service\FrontlineService;
use Application\Profile\Entity\Profile;

class AuthBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function initFrontline(Container $container, FrontlineService $frontlineService)
    {
        $container->call(function(CurrentAccountService $currentAccountService) use ($frontlineService) {
            $frontlineService::$exporters->addExporter("auth", function() use ($currentAccountService) {
                if($currentAccountService->isAvailable()) {
                    return [
                        'auth' => [
                            'api_key' => $currentAccountService->getCurrentAccount()->getAPIKey(),
                            'account' => $currentAccountService->getCurrentAccount()->toJSON(),
                            'profiles' => array_map(function(Profile $profile) {
                                return $profile->toJSON();
                            }, $currentAccountService->getCurrentAccount()->getProfiles()->toArray())
                        ]
                    ];
                }else{
                    return [];
                }
            });
        });
    }


    public function getDir()
    {
        return __DIR__;
    }
}