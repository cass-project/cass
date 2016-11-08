<?php
namespace CASS\Domain\Bundles\Profile;

use CASS\Domain\Bundles\Profile\Doctrine\ProfileCardDoctrineType;
use Doctrine\DBAL\Types\Type;
use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Domain\Bundles\Profile\Frontline\ConfigProfileFrontlineScript;

Type::addType(ProfileCardDoctrineType::TYPE_NAME, ProfileCardDoctrineType::class);

class ProfileBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            ConfigProfileFrontlineScript::class
        ];
    }
}