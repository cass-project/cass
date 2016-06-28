<?php
namespace Domain\Feedback;

use Application\Bundle\GenericBundle;
use Application\Frontline\FrontlineBundleInjectable;
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