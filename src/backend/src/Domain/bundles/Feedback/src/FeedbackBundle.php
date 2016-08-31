<?php
namespace Domain\Feedback;

use CASS\Application\Bundle\GenericBundle;
use CASS\Application\Frontline\FrontlineBundleInjectable;
use Domain\Feedback\Frontline\FeedbackTypesFrontlineScript;

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