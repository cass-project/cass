<?php
namespace CASS\Domain\Bundles\Feedback\FeedbackType\Types;

use CASS\Domain\Bundles\Feedback\FeedbackType\FeedbackType;

abstract class AbstractFeedbackType implements FeedbackType
{
    public function toJSON(): array
    {
        return [
            'code' => [
                'int' => $this->getIntCode(),
                'string' => $this->getStringCode()
            ],
            'title' => $this->getTitle(),
            'description' => $this->getDescription()
        ];
    }
}