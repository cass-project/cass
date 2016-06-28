<?php
namespace Domain\Feedback\FeedbackType;

interface FeedbackType
{
    public function getIntCode(): int;
    public function getStringCode(): string;
}