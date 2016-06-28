<?php
namespace Domain\Feedback\Frontline;

use Application\Frontline\FrontlineScript;
use Domain\Feedback\FeedbackType\FeedbackTypeFactory;

final class FeedbackTypesFrontlineScript implements FrontlineScript
{
    /** @var FeedbackTypeFactory */
    private $factory;
    
    public function __construct(FeedbackTypeFactory $factory)
    {
        $this->factory = $factory;
    }

    public function tags(): array
    {
        return [
            FrontlineScript::TAG_GLOBAL
        ];
    }

    public function __invoke(): array
    {
        $types = array_map(function(int $code) {
            return $this->factory->createFromIntCode($code)->toJSON();
        }, $this->factory->listCodes());
        
        return [
            'config' => [
                'feedback' => [
                    'types' => $types
                ]
            ]
        ];
    }
}