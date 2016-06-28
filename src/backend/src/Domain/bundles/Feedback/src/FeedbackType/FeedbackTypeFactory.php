<?php
namespace Domain\Feedback\FeedbackType;

use Domain\Feedback\Exception\InvalidFeedbackTypeException;
use Domain\Feedback\FeedbackType\Types\FTCommonQuestion;
use Domain\Feedback\FeedbackType\Types\FTSuggestion;
use Domain\Feedback\FeedbackType\Types\FTThemeRequest;

final class FeedbackTypeFactory
{
    public function createFromIntCode(int $code): FeedbackType
    {
        switch($code) {
            default:
                throw new InvalidFeedbackTypeException(sprintf('Invalid feedback type `%s`', $code));

            case FTCommonQuestion::INT_CODE: return new FTCommonQuestion();
            case FTSuggestion::INT_CODE: return new FTSuggestion();
            case FTThemeRequest::INT_CODE: return new FTThemeRequest();
        }
    }
}