<?php
namespace CASS\Domain\Feedback;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Bundles\Frontline\FrontlineBundleInjectable;
use CASS\Domain\Feedback\Frontline\FeedbackTypesFrontlineScript;

class FeedbackBundle extends GenericBundle implements FrontlineBundleInjectable
{
    public function getDir()
    {
        return __DIR__;
    }

    public function getFrontlineScripts(): array
    {
        return [
            FeedbackTypesFrontlineScript::class,
        ];
    }
}